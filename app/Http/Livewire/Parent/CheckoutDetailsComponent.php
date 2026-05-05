<?php

namespace App\Http\Livewire\Parent;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Mail\NewOrderMail;
use App\Models\BookedProgram;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductSubscription;
use App\Models\Program;
use App\Models\ProgramOrder;
use App\Models\ProgramOrderChildren;
use Livewire\Component;
use Illuminate\Validation\Rule;

use App\Traits\WithLockedProperties;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CheckoutDetailsComponent extends Component
{
    use WithLockedProperties;
    public $products = [];
    public $programs = [];
    public $subTotal;
    public $discount;
    public $shippingCharges = 0;
    public $vat;
    public $sst;
    public $netTotal;
    public $states = [];
    public $countries = [];
    public Order $order;
    public $programsSubTotal = 0;
    public $programsDiscount = 0;
    public $programsNetTotal = 0;
    public $grandSubTotal = 0;
    public $grandTotal = 0;
    public $grandDiscount = 0;
    public $payment_method = 'ipay88';

    protected function rules()
    {
        return [
            'order.name' => 'required',
            'order.email' => 'required',
            'order.phone' => 'required',
            'order.company' => 'nullable',
            'order.street_address' => 'required',
            'order.house_name_number' => 'nullable',
            'order.postal_code' => 'required',
            'order.city' => 'required',
            'order.state' => Rule::requiredIf(count($this->products) > 0),
            'order.country' => 'nullable',
            'order.order_notes' => 'nullable',
        ];
    }

    public function mount()
    {
        $this->order = new Order();
        $this->order->country = 'Malaysia';
        $this->getProducts();
        $this->getStates();

        $this->countries = Country::all();
    }

    public function lockedProps()
    {
        return [
            'subTotal',
            'discount',
            'shippingCharges',
            'vat',
            'netTotal',
        ];
    }

    public function getStates()
    {
        $this->states = [
            ['name' => 'Johor',  'rate' => '8'],
            ['name' => 'Kedah',  'rate' => '8'],
            ['name' => 'Kelantan',  'rate' => '8'],
            ['name' => 'Melaka',  'rate' => '8'],
            ['name' => 'Negeri Sembilan',  'rate' => '8'],
            ['name' => 'Pahang',  'rate' => '8'],
            ['name' => 'Perak',  'rate' => '8'],
            ['name' => 'Perlis',  'rate' => '8'],
            ['name' => 'Pulau Pinang',  'rate' => '8'],
            ['name' => 'Selangor',  'rate' => '8'],
            ['name' => 'Terengganu',  'rate' => '8'],
            ['name' => 'Wilayah Persekutuan Kuala Lumpur',  'rate' => '8'],
            ['name' => 'Wilayah Persekutuan Putrajaya',  'rate' => '8'],
            ['name' => 'Sabah', 'rate' => '15'],
            ['name' => 'Sarawak', 'rate' => '15'],
            ['name' => 'Wilayah Persekutuan Labuan', 'rate' => '15'],
        ];
    }

    public function orderState()
    {
        $selectedState = $this->order['state'];
        # Do not calculate shipping if there is no products
        if (!count($this->products)) {
            $this->shippingCharges = 0;
        } else {
            $maxSubscriptionMonths = collect($this->products)->pluck('subscription_months')->max();
            foreach ($this->states as $state) {
                if ($state['name'] === $selectedState) {
                    $this->shippingCharges = (float) ($state['rate'] ?? 0) * (int) ($maxSubscriptionMonths ?? 1);

                    break;
                } else {
                    $this->shippingCharges =  0;
                }
            }
        }
        $this->calculate();
    }



    public function calculate()
    {
        // $this->shippingCharges=0;
        $this->subTotal = 0;
        foreach ($this->products as $p) {
            $this->subTotal += ($p['quantity'] * $p['price']);
        }
        $this->discount = 0;
        $this->vat = 0;
        $this->netTotal = ($this->subTotal - $this->discount) + $this->shippingCharges + $this->vat;

        #calculate total for programs
        $this->programsSubTotal = 0;
        $this->programsDiscount = 0;
        $this->programsNetTotal = 0;

        $this->sst = 0;

        #Calculate programs total
        foreach ($this->programs as $program) {
            $order = $program['order'];
            $this->programsSubTotal += $order['sub_total'];
            $this->programsDiscount += $order['discount'];
            $this->programsNetTotal += $order['net_total'];

            $this->sst += $order['sst'];
        }

        #Calculate grand totals
        $this->grandSubTotal = $this->programsSubTotal + $this->subTotal + $this->shippingCharges;
        $this->grandDiscount = $this->programsDiscount + $this->discount;
        $this->grandTotal = $this->netTotal + $this->programsNetTotal;
    }

    public function getProducts()
    {
        $this->products = session('cart') ? session('cart') : [];
        $this->programs = session('cart_programs', []);
        $this->calculate();
    }

    public function saveOrder()
    {
        $this->validate();
        $this->getProducts();
        try {
            DB::beginTransaction();
            $this->order->shipping_charges = $this->shippingCharges;
            $this->order->sub_total = $this->subTotal;
            $this->order->discount = $this->discount;
            $this->order->sst = $this->sst;
            $this->order->vat = $this->vat;
            $this->order->net_total = $this->netTotal;
            $this->order->programs_net_total = $this->programsNetTotal;
            $this->order->grand_net_total = $this->grandTotal;
            $this->order->grand_sub_total = $this->grandSubTotal;
            $this->order->grand_discount = $this->grandDiscount;
            $this->order->payment_status = PaymentStatus::NotPaid;
            $this->order->order_status = OrderStatus::NotPaid;
            $this->order->user_id = auth()->id();
            $this->order->save();
            $subscription = null;
            foreach ($this->products as $product) {
                if ($product['is_subscription']) {
                    $subscription =  ProductSubscription::create([
                        'product_id' => $product['id'],
                        'user_id' => auth()->id(),
                        'order_id' => $this->order->id,
                        'start_date' => now(),
                        'subscribed_for' => $product['subscription_months'],
                        'end_date' => now()->addMonths($product['subscription_months']),
                        'status' => 'active',
                    ]);
                }

                OrderItem::create([
                    'order_id' => $this->order->id,
                    'subscription_id' => $subscription ? $subscription->id : null,
                    'product_id' => $product['id'],
                    'is_subscription' => $product['is_subscription'],
                    'subscription_months' => $product['subscription_months'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $product['quantity'],
                    'variation' => array_key_exists('variation', $product) ?  $product['variation'] : '',
                    'total' => $product['price'] * $product['quantity'],
                ]);
            }

            // if((bool)(env('ENABLE_EMAILS',false))){
            //     Mail::to($this->order->email)->send(new NewOrderMail($this->order));
            // }

            // Start Program Orders

            foreach ($this->programs as $program) {
                $program['order']['shop_order_id'] = $this->order->id;
                $program['order']['name'] = $this->order->name;
                $program['order']['email'] = $this->order->email;
                $program['order']['phone'] = $this->order->phone;
                $program['order']['company'] = $this->order->company;
                $program['order']['address'] = $this->order->full_address;

                unset($program['order']['unit_price']);
                $programOrder = ProgramOrder::create($program['order']);

                // Get Form id from program
                $formId = Program::where('id', $program['order']['program_id'])->value('form_id');


                foreach ($program['children'] as $child) {
                    $child['program_order_id'] = $programOrder->id;
                    $child['form_id'] = $formId;
                    ProgramOrderChildren::create($child);
                }

                #save booked program

                $program['bookedProgram']['program_order_id'] = $programOrder->id;
                BookedProgram::create($program['bookedProgram']);

                $programOrder->generateInvoice();
                $programOrder->generateChildrenDetails();
            }

            // END
            DB::commit();

            $this->order->refresh();
            $this->order->generateInvoice();

            session()->forget('cart');
            session()->forget('cart_programs');

            $this->getProducts();
            $this->dispatchBrowserEvent('success-prompt', ['message' => 'Order Placed, Please pay to confirm the order.']);
            if ($this->payment_method == 'senangpay') {
                return redirect()->route('payment.checkout', ["shop", $this->order->id]);
            } else if ($this->payment_method == 'ipay88') {
                return redirect()->route('payment.checkout-ipay', ["shop", $this->order->id]);
            }
            $this->order = new Order();
        } catch (\Exception $e) {
            \Log::error('Error Creating Shop Order: ' . $e->getMessage());
            \Log::error($e);
            DB::rollBack();
            $this->dispatchBrowserEvent('error-prompt', ['message' => 'Something went wrong. Please refesh page and try again. If error still persist, Contact admin in contact us page.']);
        }
    }

    public function render()
    {
        return view('livewire.parent.checkout-details-component');
    }
}

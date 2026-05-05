<?php

namespace App\Http\Livewire\Program;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Mail\NewOrderMail;
use App\Models\BookedProgram;
use App\Models\Country;
use App\Models\Order;
use App\Models\Program;
use App\Models\ProgramGroup;
use App\Models\ProgramOrder;
use App\Models\ProgramOrderChildren;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ProgramCheckoutDetailsComponent extends Component
{
    public Program $program;
    public ProgramGroup $group;
    public ProgramOrder $order;
    public $subTotal = 0;
    public $discount = 0;
    public $sst = 0;
    public $vat = 0;
    public $netTotal = 0;
    public $children = [];
    public $guardians = [];
    public $guardians2 = [];
    public $questions = [];
    public $currentStep = 0;
    public $myChildren = [];
    public $filledChildrenQuestions = [];
    public $currentQuestionsIndex = 0;
    public $countries = [];

    public function mount()
    {
        $this->order = new ProgramOrder();
        $this->questions = $this->getFormQuestions();
        // foreach ($this->questions as $index => $q) {
        //     if ($q['answer_type'] == 'options_multiple') {
        //         $this->questions[$index]['answer'] = [];
        //     } else {
        //         $this->questions[$index]['answer'] = '';
        //     }
        // }
        $this->myChildren = auth()->user()->children()->with('guardian2')->get()->toArray();
        $this->countries = Country::all();
    }
    public function getFormQuestions()
    {
        $formID = $this->program->form->id;
        $questions = [];
        if ($formID) {
            $questions = $this->program->form->getQuestions();
            if (count($questions) && $this->currentQuestionsIndex == 0) {
                $lastFilledChild = ProgramOrderChildren::where('form_id', $formID)->whereHas('order', function ($q) {
                    $q->where('user_id', auth()->id());
                })->latest()->first();
                if ($lastFilledChild) {
                    $questionsWithAnswers = collect($lastFilledChild->questionDetails());
                    foreach ($questions as $qIndex => $question) {
                        $foundAnswer = $questionsWithAnswers->where('title', $question['title'])->where('answer_type', $question['answer_type'])->where('is_heading', false)->first();
                        if ($foundAnswer) {
                            if ($foundAnswer['answer_type'] == 'options_multiple') {
                                $questions[$qIndex]['answer'] = explode(',', $foundAnswer['answer']);
                            } else {
                                $questions[$qIndex]['answer'] = $foundAnswer['answer'];
                            }
                        } else {
                            $questions[$qIndex]['answer'] = $this->getDefaultAnswer($question);
                        }
                    }
                }
            } else {
                // fetch from last filled
                if (count($questions)) {
                    $questions = $this->filledChildrenQuestions[$this->currentQuestionsIndex - 1];
                }
            }
        }
        return $questions;
    }

    public function getDefaultAnswer($question)
    {
        if ($question['answer_type'] == 'options_multiple') {
            return [];
        } else {
            return '';
        }
    }

    public function updatedChildren($value, $key)
    {
        if (str_contains($key, 'date_of_birth')) {
            [$index] = explode('.', $key); // index of child row

            if (!empty($this->children[$index]['date_of_birth'])) {
                $dob = \Carbon\Carbon::parse($this->children[$index]['date_of_birth']);
                $this->children[$index]['age'] = $dob->age; // auto calculate age
            } else {
                // optional: clear age if dob removed
                $this->children[$index]['age'] = null;
            }
        }
    }

    protected function rules()
    {
        return [
            'order.name' => 'required',
            'order.email' => 'required',
            'order.phone' => 'required',
            'order.company' => 'nullable',
            'order.address' => 'required',
            'order.notes' => 'nullable',
            'order.booked_for_date' => 'nullable',
            'myChildren.*.name' => 'nullable',

            'children.*.name' => 'required',
            'children.*.age' => 'required',
            'children.*.passport_no' => 'required',
            'children.*.date_of_birth' => 'required',
            'children.*.gender' => 'required',
            'children.*.nationality' => 'required',
            'children.*.name_of_school_attending' => 'nullable',
            'children.*.current_grade_in_school' => 'nullable',


            'guardians.*.name' => 'nullable',
            'guardians.*.relationship' => 'nullable',
            'guardians.*.email' => 'nullable',
            'guardians.*.contact_no' => 'nullable',
            'guardians.*.nationality' => 'nullable',
            'guardians.*.residential_address' => 'nullable',

            'guardians2.*.name' => 'nullable',
            'guardians2.*.relationship' => 'nullable',
            'guardians2.*.email' => 'nullable',
            'guardians2.*.contact_no' => 'nullable',
            'guardians2.*.nationality' => 'nullable',
            'guardians2.*.residential_address' => 'nullable',
        ];
    }

    public function saveQuestions()
    {
        $this->validate([
            'questions.*.answer' => 'nullable',
        ]);
        $this->filledChildrenQuestions[$this->currentQuestionsIndex] = $this->questions;
        if (array_key_exists($this->currentQuestionsIndex + 1, $this->children)) {
            $this->currentQuestionsIndex++;
            $this->questions = $this->getFormQuestions();
            $this->dispatchBrowserEvent('success-notification', ['message' => 'Information Saved Successfully, Fill Info For next Child']);
        } else {
            $this->currentStep = 2;
            # Add to cart here
            $this->addToCart();
        }
        $this->dispatchBrowserEvent('scroll-to-top');
    }

    public function alreadyHasSameProgramInCart()
    {
        #Get All programs in cart
        $programsInCart = collect(session('cart_programs', []));
        #Check if same program exist in cart
        if ($programsInCart->contains(function ($item, $key) {
            return data_get($item, 'order.program_id') == $this->program->id;
        })) {
            // An item with 'program_id' equal to $this->program->id exists in the collection.
            return true;
        }
        return false;
    }

    public function calculate()
    {
        $count = 1;
        $program = Program::find($this->group->program->id);
        foreach ($this->children as $index => $child) {
            $child['sub_total'] = $this->group->price;
            if ($count > 1 && $program->type == 'sevent') {
                $child['discount'] = 0;
                $child['discount_detail'] = '';
                $child['net_total'] = $child['sub_total'] - $child['discount'];
                $this->children[$index] = $child;
                $count++;
            } else if ($count > 1 && ($program->type == 'mom' || $program->type == 'dom')) {
                $child['discount'] = 0;
                $child['discount_detail'] = '';
                $child['net_total'] = 250 - $child['discount'];
                $this->children[$index] = $child;
                $count++;
            } else {
                $child['discount'] =
                    ($count > 1 || $this->alreadyHasSameProgramInCart())
                    ? (10 / 100) * $child['sub_total']
                    : 0;
                $child['discount_detail'] = $child['discount'] > 0 ? '10% discount for sibling' : '';
                $child['net_total'] = $child['sub_total'] - $child['discount'];
                $this->children[$index] = $child;
                $count++;
            }
        }
        $children_collection = collect($this->children);
        if ($program->type == 'mom' || $program->type == 'dom') {
            $this->subTotal = $children_collection->sum('net_total');
        } else {
            $this->subTotal = $children_collection->sum('sub_total');
        }
        $this->discount = $children_collection->sum('discount');
        $this->sst = 0;
        if ($this->program->is_sst_applicable) {
            $this->sst = ($this->subTotal - $this->discount) * (getSstValue()); // means 8% of the total
        }
        $this->vat = 0;
        $this->netTotal = ($this->subTotal - $this->discount) + $this->vat + $this->sst;
    }

    public function addChild()
    {
        $this->children[] = [
            'name' => '',
            'age' => '',
            'sub_total' => 0,
            'discount' => 0,
            'discount_detail' => 0,
            'net_total' => 0,
        ];
        $this->guardians[] = [
            'name' => '',
            'relationship' => '',
            'email' => '',
            'contact_no' => '',
            'nationality' => '',
            'residential_address' => '',
        ];

        $this->guardians2[] = [
            'name' => '',
            'relationship' => '',
            'email' => '',
            'contact_no' => '',
            'nationality' => '',
            'residential_address' => '',
        ];
        $this->calculate();
    }

    public function removeChild($index)
    {
        unset($this->children[$index]);
        unset($this->guardians[$index]);
        unset($this->guardians2[$index]);
        unset($this->filledChildrenQuestions[$index]);
        $this->children = array_values($this->children);
        $this->guardians = array_values($this->guardians);
        $this->guardians2 = array_values($this->guardians2);
        $this->filledChildrenQuestions = array_values($this->filledChildrenQuestions);
        $this->calculate();
    }

    public function saveChildrenDetails()
    {
        $this->validate([
            'children.*.name' => 'required',
            'children.*.age' => 'required|numeric',
            'children.*.passport_no' => 'required',
            'children.*.date_of_birth' => 'required',
            'children.*.gender' => 'required',
            'children.*.nationality' => 'required',

            'guardians.*.name' => 'required',
            'guardians.*.relationship' => 'required',
            'guardians.*.email' => 'required',
            'guardians.*.contact_no' => 'required',
            'guardians.*.residential_address' => 'required',
            'guardians.*.nationality' => 'required',

            'guardians2.*.name' => 'nullable',
            'guardians2.*.relationship' => 'nullable',
            'guardians2.*.email' => 'nullable',
            'guardians2.*.contact_no' => 'nullable',
            'guardians2.*.residential_address' => 'nullable',
            'guardians2.*.nationality' => 'nullable',
        ]);
        if (count($this->questions)) {
            $this->currentStep = 1;
        } else {
            $this->currentStep = 2;
            # Add to cart here
            $this->addToCart();
        }
        $this->dispatchBrowserEvent('scroll-to-top');
    }

    public function addToCart()
    {
        if (!count($this->children)) {
            $this->dispatchBrowserEvent('error-prompt', ['message' => 'Please add at least 1 child to continue!']);
            return false;
        }
        $dataForCart = [];

        $this->order->booked_for_date = $this->group->start_date;

        $this->order->program_id = $this->program->id;
        $this->order->program_title = $this->program->title;
        $this->order->sub_total = $this->subTotal;
        $this->order->discount = $this->discount;
        $this->order->vat = $this->vat;
        $this->order->sst = $this->sst;
        $this->order->net_total = $this->netTotal;
        $this->order->payment_status = PaymentStatus::NotPaid;
        $this->order->children_count = count($this->children);
        $this->order->user_id = auth()->id();
        $this->order->group_id = $this->group->id;
        $dataForCart['order'] = $this->order->toArray();
        $dataForCart['order']['unit_price'] = $this->group->price;

        foreach ($this->children as $index => $child) {
            $child = new  ProgramOrderChildren([
                'program_order_id' => $this->order->id,
                'name' => $child['name'],
                'age' => $child['age'],
                'passport_no' => $child['passport_no'],
                'date_of_birth' => $child['date_of_birth'],
                'gender' => $child['gender'],
                'nationality' => $child['nationality'],
                'guardian' => json_encode($this->guardians[$index]),
                'guardian2' => json_encode($this->guardians2[$index]),
                'questions' => array_key_exists($index, $this->filledChildrenQuestions) ?  json_encode($this->filledChildrenQuestions[$index]) : "{}",
                'sub_total' => $child['sub_total'],
                'discount' => $child['discount'],
                'discount_detail' => $child['discount_detail'],
                'net_total' => $child['net_total'],
            ]);
            $dataForCart['children'][] = $child->toArray();
        }

        #save booked program
        $bookedProgram = (new BookedProgram())->fill([
            'program_id' => $this->program->id,
            'group_id' => $this->group->id,
            'program_order_id' => $this->order->id,
            'title' => $this->program->title,
            'venue' => $this->program->venue,
            'start_date' => $this->group->start_date,
            'end_date' => $this->group->end_date,
            'age_group' => $this->group->age_group,
            'age_group_extra_info' => $this->group->age_group_extra_info,
            'price' => $this->group->price,
            'pick_and_drop' => $this->program->pick_and_drop,
            'timetable' => json_encode($this->program->timetables),
            'time' => $this->group->time,
        ]);
        $dataForCart['bookedProgram'] = $bookedProgram->toArray();
        $this->emitTo('parent.cart-component', 'addProgram', $dataForCart);
    }

    public function saveOrder()
    {
        if (!count($this->children)) {
            $this->dispatchBrowserEvent('error-prompt', ['message' => 'Please add at least 1 child to continue!']);
            return false;
        }
        $this->validate([
            'order.name' => 'required',
            'order.email' => 'required',
            'order.phone' => 'required',
            'order.company' => 'nullable',
            'order.address' => 'required',
            'order.notes' => 'nullable',
        ]);

        $this->order->booked_for_date = $this->group->start_date;

        $this->order->program_id = $this->program->id;
        $this->order->program_title = $this->program->title;
        $this->order->sub_total = $this->subTotal;
        $this->order->discount = $this->discount;
        $this->order->vat = $this->vat;
        $this->order->net_total = $this->netTotal;
        $this->order->payment_status = PaymentStatus::NotPaid;
        $this->order->children_count = count($this->children);
        $this->order->user_id = auth()->id();
        $this->order->group_id = $this->group->id;
        $this->order->save();

        foreach ($this->children as $index => $child) {
            $child = new  ProgramOrderChildren([
                'program_order_id' => $this->order->id,
                'name' => $child['name'],
                'age' => $child['age'],
                'passport_no' => $child['passport_no'],
                'date_of_birth' => $child['date_of_birth'],
                'gender' => $child['gender'],
                'nationality' => $child['nationality'],
                'name_of_school_attending' => $child['name_of_school_attending'],
                'current_grade_in_school' => $child['current_grade_in_school'],
                'guardian' => json_encode($this->guardians[$index]),
                'guardian2' => json_encode($this->guardians2[$index]),
                'questions' => array_key_exists($index, $this->filledChildrenQuestions) ?  json_encode($this->filledChildrenQuestions[$index]) : "{}",
                'sub_total' => $child['sub_total'],
                'discount' => $child['discount'],
                'discount_detail' => $child['discount_detail'],
                'net_total' => $child['net_total'],
            ]);
            $child->save();
        }

        #save booked program
        $bookedProgram = (new BookedProgram())->fill([
            'program_id' => $this->program->id,
            'group_id' => $this->group->id,
            'program_order_id' => $this->order->id,
            'title' => $this->program->title,
            'venue' => $this->program->venue,
            'start_date' => $this->group->start_date,
            'end_date' => $this->group->end_date,
            'age_group' => $this->group->age_group,
            'age_group_extra_info' => $this->group->age_group_extra_info,
            'price' => $this->group->price,
            'pick_and_drop' => $this->program->pick_and_drop,
            'timetable' => json_encode($this->program->timetables),
            'time' => $this->group->time,
        ]);
        $bookedProgram->save();

        $this->order->generateInvoice();
        $this->order->generateChildrenDetails();
        // if ((bool)(env('ENABLE_EMAILS', false))) {
        //     Mail::to($this->order->email)->send(new NewOrderMail($this->order));
        // }

        $this->dispatchBrowserEvent('success-prompt', ['message' => 'Order saved successfully, Please Wait while we redirect you to the payment.']);

        return redirect()->route('payment.checkout', ['camp', $this->order->id]);
        $this->order = new Order();
        $this->children = [];
    }

    public function goBack()
    {
        if (count($this->questions)) {
            $this->currentStep = 1;
        } else {
            $this->currentStep = 0;
        }
        $this->dispatchBrowserEvent('scroll-to-top');
    }

    public function fillChild($myChildrenIndex, $childrenIndex)
    {
        $this->children[$childrenIndex]['name'] = $this->myChildren[$myChildrenIndex]['name'];
        $this->children[$childrenIndex]['age'] = $this->myChildren[$myChildrenIndex]['age'];
        $this->children[$childrenIndex]['passport_no'] = $this->myChildren[$myChildrenIndex]['passport_no'];
        $this->children[$childrenIndex]['date_of_birth'] = $this->myChildren[$myChildrenIndex]['date_of_birth'];
        $this->children[$childrenIndex]['gender'] = $this->myChildren[$myChildrenIndex]['gender'];
        $this->children[$childrenIndex]['nationality'] = $this->myChildren[$myChildrenIndex]['nationality'];
        $this->children[$childrenIndex]['name_of_school_attending'] = $this->myChildren[$myChildrenIndex]['name_of_school_attending'];
        $this->children[$childrenIndex]['current_grade_in_school'] = $this->myChildren[$myChildrenIndex]['current_grade_in_school'];

        if ($this->myChildren[$myChildrenIndex]['guardian'] != []) {
            $this->guardians[$childrenIndex]['name'] = $this->myChildren[$myChildrenIndex]['guardian']['name'];
            $this->guardians[$childrenIndex]['relationship'] = $this->myChildren[$myChildrenIndex]['guardian']['relationship'];
            $this->guardians[$childrenIndex]['email'] = $this->myChildren[$myChildrenIndex]['guardian']['email'];
            $this->guardians[$childrenIndex]['contact_no'] = $this->myChildren[$myChildrenIndex]['guardian']['contact_no'];
            $this->guardians[$childrenIndex]['nationality'] = $this->myChildren[$myChildrenIndex]['guardian']['nationality'];
            $this->guardians[$childrenIndex]['residential_address'] = $this->myChildren[$myChildrenIndex]['guardian']['residential_address'];
        }

        if ($this->myChildren[$myChildrenIndex]['guardian2'] != []) {

            $this->guardians2[$childrenIndex]['name'] = $this->myChildren[$myChildrenIndex]['guardian2']['name'];
            $this->guardians2[$childrenIndex]['relationship'] = $this->myChildren[$myChildrenIndex]['guardian2']['relationship'];
            $this->guardians2[$childrenIndex]['email'] = $this->myChildren[$myChildrenIndex]['guardian2']['email'];
            $this->guardians2[$childrenIndex]['contact_no'] = $this->myChildren[$myChildrenIndex]['guardian2']['contact_no'];
            $this->guardians2[$childrenIndex]['nationality'] = $this->myChildren[$myChildrenIndex]['guardian2']['nationality'];
            $this->guardians2[$childrenIndex]['residential_address'] = $this->myChildren[$myChildrenIndex]['guardian2']['residential_address'];
        }
    }


    public function render()
    {
        return view('livewire.program.program-checkout-details-component');
    }
}

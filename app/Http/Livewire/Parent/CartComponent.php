<?php

namespace App\Http\Livewire\Parent;

use App\Models\Product;
use App\Models\Program;
use Livewire\Component;
use Illuminate\Support\Str;

class CartComponent extends Component
{
    public $products;
    public $subTotal = 0;
    public $total = 0;
    public $programsSubTotal = 0;
    public $programsDiscount = 0;
    public $programsNetTotal = 0;
    public $sst = 0;
    public $subscriptionPrice = 0;
    public $grandTotal = 0;

    // Promotion Variables
    public $promoDiscount = 0;
    public $promotionsData = [];

    protected function getListeners()
    {
        return [
            'add' => 'addToCart',
            'addProgram' => 'addProgramToCart'
        ];
    }

    public function calculate()
    {
        $this->subTotal = 0;
        foreach ($this->products as $p) {
            $product = Product::find($p['id']);

            if ($product->is_subscription) {
                // Subscription product (Always add once, no quantity)
                $this->subTotal += $p['price'];
            } else {
                // Regular product
                $this->subTotal += ($p['quantity'] * $p['price']);
            }
        }
        $this->total = $this->subTotal;
        #calculate total for programs
        $this->programsSubTotal = 0;
        $this->programsDiscount = 0;
        $this->programsNetTotal = 0;
        #Get Data from session
        $programsInCart = collect(session('cart_programs', []));
        $this->sst = 0;
        #foreach order
        foreach ($programsInCart as $program) {
            $order = $program['order'];
            $this->programsSubTotal += $order['sub_total'];
            $this->programsDiscount += $order['discount'];
            $this->programsNetTotal += $order['net_total'];
            $this->sst += $order['sst'];
        }
        $this->grandTotal = $this->total + $this->programsNetTotal;

        // Re-evaluate promotions after totals are calculated
        $this->evaluatePromotions();
        if ($this->promoDiscount > 0) {
            $this->grandTotal -= $this->promoDiscount;
            // ensure it doesn't go negative
            if ($this->grandTotal < 0) {
                $this->grandTotal = 0;
            }
        }
    }

    public function evaluatePromotions()
    {
        $user = auth()->user();

        // Get arrays directly safely
        $products = $this->products ?: [];
        $programsInCart = session('cart_programs', []);

        $applier = app(\App\Services\PromotionApplier::class);
        $result = $applier->applyToCart($products, $programsInCart, $user);

        if ($result['discount'] > 0 || !empty($result['free_gifts']) || !empty($result['applied_promotions'])) {
            $this->promoDiscount = $result['discount'];
            $this->promotionsData = $result;
            return true;
        } else {
            $this->promoDiscount = 0;
            $this->promotionsData = [];
            return false;
        }
    }

    public function addToCart($id, $quantity = 'empty', $variation = null, $price = 0, $months = 0)
    {
        $this->subscriptionPrice = $price;
        $product = Product::find($id);
        if ($quantity != 'empty' && $quantity < 1 && !$product->is_subscription) {
            $this->remove($id, $variation);
            return;
        }

        if ($quantity == 'empty') {
            $quantity = 1;
        }

        if (!$product) {
            $this->dispatchBrowserEvent('error-prompt', ['message' => 'Product Not Found!']);
            return 1;
        }

        $cartFromSession = session()->get('cart');
        // if cart is empty then this the first product
        if (!$cartFromSession) {
            $cartFromSession = [];
        }

        // Make cart array to collection
        $cartCollection = collect($cartFromSession);
        $variationImage = null;
        if ($variation) {
            $variationImage = $product->variations()->where('title', $variation)->first()->image;
        }
        $productToAdd = [
            "id" => $product->id,
            "name" => $product->title,
            "quantity" => $product->is_subscription ? 1 : $quantity,
            "price" => $product->is_subscription ? $price : $product->price,
            "slug" => $product->slug,
            "photo" => $variationImage ? $variationImage : $product->main_image,
            "variation" => $variation,
            "is_subscription" => $product->is_subscription,
            "subscription_months" => $months
        ];
        $f = null;
        if ($variation) {
            $f = $cartCollection->where('id', $product->id)->where('variation', $variation)->first();
        } else {
            $f = $cartCollection->where('id', $product->id)->where('variation', '')->first();
        }

        if ($f) {
            $cartCollection = $cartCollection->map(function ($item, $key) use ($product, $quantity, $variation) {
                if ($item['id'] == $product->id && $item['variation'] == $variation) {
                    $item['quantity'] = $product->is_subscription ? 1 : $quantity;
                    $item['variation'] = $variation;
                }
                return $item;
            });
        } else {
            $cartCollection->push($productToAdd);
        }
        // if($cartCollection->contains('id', $product->id) && $cartCollection->where('id',$product->id)->contains('variation', $variation)){
        //
        // }

        session()->put('cart', $cartCollection->toArray());

        $this->evaluatePromotions(); // evaluates promotions for programs added

        $this->emit('productAdded');
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Product added to cart successfully!']);
    }

    public function remove($productId, $variation = null)
    {
        $cartFromSession = session()->get('cart');
        if (!$cartFromSession) {
            // $cartFromSession=[];
            $this->emit('productRemoved');
            $this->dispatchBrowserEvent('success-notification', ['message' => 'Product removed successfully']);
            return;
        }
        $cartCollection = collect($cartFromSession);

        $cartCollection = $cartCollection->filter(function ($item) use ($productId, $variation) {
            return $item['id'] != $productId || $item['variation'] != $variation;
        });
        session()->put('cart', $cartCollection->toArray());
        $this->emit('productRemoved');
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Product removed successfully']);
    }

    public function addProgramToCart($data)
    {
        $uuid = Str::uuid()->toString();
        $data['cart_id'] = $uuid;
        // Retrieving the existing array from the session
        $existingPrograms = session('cart_programs', []);

        // Appending a new record to the array
        $existingPrograms[] = $data;

        // Storing the updated array back in the session
        session()->put('cart_programs', $existingPrograms);
        $this->evaluatePromotions(); // evaluate promotions after adding a program
        $this->emit('productAdded');

        $this->recalculatePrograms();

        $this->dispatchBrowserEvent('success-notification', ['message' => 'Program added to cart successfully!']);
    }

    public function removeProgram($cartId)
    {
        // Retrieving the existing array from the session
        $existingPrograms = collect(session('cart_programs', []));

        // Use the filter method to remove a record based on a condition within a nested column
        $existingPrograms = $existingPrograms->filter(function ($program) use ($cartId) {
            // Replace 'nested_column' with the actual name of your nested column
            return $program['cart_id'] !== $cartId;
        });

        // Storing the updated array back in the session
        session()->put('cart_programs', $existingPrograms->toArray());

        $this->recalculatePrograms();

        $this->dispatchBrowserEvent('success-notification', ['message' => 'Program Removed From Cart!']);
    }

    // This function is for restoring cart programs while debugging
    // It Does Not affect any other data
    public function restore()
    {
        $personal_laptop = '[{"order":{"name":null,"email":null,"phone":null,"company":null,"address":null,"notes":null,"booked_for_date":"2023-09-27","program_id":3000,"program_title":"jungle camp","sub_total":200,"discount":10,"vat":0,"net_total":190,"payment_status":"not_paid","children_count":2,"user_id":1000,"group_id":1,"unit_price":"100"},"children":[{"program_order_id":null,"name":"asd","age":"12","passport_no":"123","date_of_birth":"2023-09-27","gender":"Male","nationality":"Azerbaijani","guardian":"{\"name\":\"Zahir Huber\",\"relationship\":\"sad\",\"email\":\"gugi@mailinator.com\",\"contact_no\":\"123\",\"nationality\":\"Azerbaijani\",\"residential_address\":\"Ea qui irure sunt en\"}","guardian2":"{\"name\":\"Zahir Huber\",\"relationship\":\"asdsad\",\"email\":\"gugi@mailinator.com\",\"contact_no\":\"123\",\"nationality\":\"Bahraini\",\"residential_address\":\"Ea qui irure sunt en\"}","questions":"{}","sub_total":"100","discount":0,"discount_detail":"","net_total":100},{"program_order_id":null,"name":"asd","age":"12","passport_no":"123","date_of_birth":"2023-09-27","gender":"Male","nationality":"Azerbaijani","guardian":"{\"name\":\"Zahir Huber\",\"relationship\":\"sad\",\"email\":\"gugi@mailinator.com\",\"contact_no\":\"123\",\"nationality\":\"Azerbaijani\",\"residential_address\":\"Ea qui irure sunt en\"}","guardian2":"{\"name\":\"Zahir Huber\",\"relationship\":\"asdsad\",\"email\":\"gugi@mailinator.com\",\"contact_no\":\"123\",\"nationality\":\"Bahraini\",\"residential_address\":\"Ea qui irure sunt en\"}","questions":"{}","sub_total":"100","discount":10,"discount_detail":"10% discount for sibling","net_total":90}],"bookedProgram":{"program_id":3000,"group_id":1,"program_order_id":null,"title":"jungle camp","venue":"Lahore","start_date":"2023-09-27","end_date":"2023-09-30","age_group":"12-18","age_group_extra_info":"older allowed","price":"100","pick_and_drop":"Thokar","timetable":"[]","time":"8:00 AM"},"cart_id":"4506325a-f17f-4d2a-9750-a37483dca7fb"},{"order":{"name":null,"email":null,"phone":null,"company":null,"address":null,"notes":null,"booked_for_date":"2023-10-20","program_id":3001,"program_title":"Zoo Visit","sub_total":10,"discount":0,"vat":0,"net_total":10,"payment_status":"not_paid","children_count":1,"user_id":1000,"group_id":2,"unit_price":"10"},"children":[{"program_order_id":null,"name":"asd","age":"12","passport_no":"123","date_of_birth":"2023-09-27","gender":"Male","nationality":"Azerbaijani","guardian":"{\"name\":\"Zahir Huber\",\"relationship\":\"sad\",\"email\":\"gugi@mailinator.com\",\"contact_no\":\"123\",\"nationality\":\"Azerbaijani\",\"residential_address\":\"Ea qui irure sunt en\"}","guardian2":"{\"name\":\"Zahir Huber\",\"relationship\":\"asdsad\",\"email\":\"gugi@mailinator.com\",\"contact_no\":\"123\",\"nationality\":\"Bahraini\",\"residential_address\":\"Ea qui irure sunt en\"}","questions":"{}","sub_total":"10","discount":0,"discount_detail":"","net_total":10}],"bookedProgram":{"program_id":3001,"group_id":2,"program_order_id":null,"title":"Zoo Visit","venue":"Lahore","start_date":"2023-10-20","end_date":"2023-10-26","age_group":"12","age_group_extra_info":"34","price":"10","pick_and_drop":"thokar","timetable":"[]","time":"8 am"},"cart_id":"d838bec6-b02c-433b-b6f1-31893882da99"},{"order":{"name":null,"email":null,"phone":null,"company":null,"address":null,"notes":null,"booked_for_date":"2023-10-24","program_id":3001,"program_title":"Zoo Visit","sub_total":100,"discount":10,"vat":0,"net_total":90,"payment_status":"not_paid","children_count":1,"user_id":1000,"group_id":3,"unit_price":"100"},"children":[{"program_order_id":null,"name":"asd","age":"12","passport_no":"123","date_of_birth":"2023-09-27","gender":"Male","nationality":"Azerbaijani","guardian":"{\"name\":\"Zahir Huber\",\"relationship\":\"sad\",\"email\":\"gugi@mailinator.com\",\"contact_no\":\"123\",\"nationality\":\"Azerbaijani\",\"residential_address\":\"Ea qui irure sunt en\"}","guardian2":"{\"name\":\"Zahir Huber\",\"relationship\":\"asdsad\",\"email\":\"gugi@mailinator.com\",\"contact_no\":\"123\",\"nationality\":\"Bahraini\",\"residential_address\":\"Ea qui irure sunt en\"}","questions":"{}","sub_total":"100","discount":10,"discount_detail":"10% discount for sibling","net_total":90}],"bookedProgram":{"program_id":3001,"group_id":3,"program_order_id":null,"title":"Zoo Visit","venue":"Lahore","start_date":"2023-10-24","end_date":"2023-11-02","age_group":"15","age_group_extra_info":"123","price":"100","pick_and_drop":"thokar","timetable":"[]","time":"9 am"},"cart_id":"d506ae38-6028-4bb7-81b8-958898fd67d8"}]';
        $office_laptop = '[{"order":{"name":null,"email":null,"phone":null,"company":null,"address":null,"notes":null,"booked_for_date":"2003-01-02","program_id":3001,"program_title":"Nature Science: Forest Exploration Program","sub_total":24,"discount":1.2000000000000002,"vat":0,"net_total":22.8,"payment_status":"not_paid","children_count":2,"user_id":1000,"group_id":4,"unit_price":"10"},"children":[{"program_order_id":null,"name":"Amet laudantium fu","age":"12","passport_no":"Blanditiis sint acc","date_of_birth":"2015-04-22","gender":"Male","nationality":"Albanian","guardian":"{\"name\":\"Unde voluptas alias \",\"relationship\":\"Ipsam nulla est inci\",\"email\":\"irfan@gmail.com\",\"contact_no\":\"Doloribus exercitati\",\"nationality\":\"Belarusian\",\"residential_address\":\"Fugiat praesentium v\"}","guardian2":"{\"name\":\"Zahir Huber\",\"relationship\":\"sd\",\"email\":\"gugi@mailinator.com\",\"contact_no\":\"asd\",\"nationality\":\"Afghan\",\"residential_address\":\"Ea qui irure sunt en\"}","questions":"[{\"title\":\"Hello\",\"description\":\"\",\"required\":false,\"is_heading\":true,\"answer_type\":\"\",\"options\":\"\",\"options_array\":[\"\"],\"answer\":\"\"},{\"title\":\"\",\"description\":\"\",\"required\":false,\"is_heading\":false,\"answer_type\":\"text\",\"options\":\"\",\"options_array\":[\"\"],\"answer\":\"ads\"}]","sub_total":"12","discount":0,"discount_detail":"","net_total":12},{"program_order_id":null,"name":"Velit quisquam prae","age":"1","passport_no":"Omnis dolores sit m","date_of_birth":"1989-11-23","gender":"Female","nationality":"Algerian","guardian":"{\"name\":\"Unde voluptas alias \",\"relationship\":\"Ipsam nulla est inci\",\"email\":\"irfan@gmail.com\",\"contact_no\":\"Doloribus exercitati\",\"nationality\":\"Belarusian\",\"residential_address\":\"Fugiat praesentium v\"}","guardian2":"{\"name\":\"Zahir Huber\",\"relationship\":\"as\",\"email\":\"gugi@mailinator.com\",\"contact_no\":\"sad\",\"nationality\":\"American Samoan\",\"residential_address\":\"Ea qui irure sunt en\"}","questions":"[{\"title\":\"Hello\",\"description\":\"\",\"required\":false,\"is_heading\":true,\"answer_type\":\"\",\"options\":\"\",\"options_array\":[\"\"]},{\"title\":\"\",\"description\":\"\",\"required\":false,\"is_heading\":false,\"answer_type\":\"text\",\"options\":\"\",\"options_array\":[\"\"],\"answer\":\"ads\"}]","sub_total":"12","discount":1.2000000000000002,"discount_detail":"10% discount for sibling","net_total":10.8}],"bookedProgram":{"program_id":3001,"group_id":4,"program_order_id":null,"title":"Nature Science: Forest Exploration Program","venue":"Taman Persekutuan Bukit Kiara, TTDI","start_date":"2003-01-02","end_date":null,"age_group":"12-16","age_group_extra_info":"One parent allowed","price":"12","pick_and_drop":"Pick and drop","timetable":"[]","time":"Nostrum maxime id ni"},"cart_id":"2bf55bf3-44a3-4f9e-8635-3577abcd83f8"},{"order":{"name":null,"email":null,"phone":null,"company":null,"address":null,"notes":null,"booked_for_date":"2023-07-18","program_id":3001,"program_title":"Nature Science: Forest Exploration Program","sub_total":2000,"discount":200,"vat":0,"net_total":1800,"payment_status":"not_paid","children_count":2,"user_id":1000,"group_id":2,"unit_price":"1000"},"children":[{"program_order_id":null,"name":"Amet laudantium fu","age":"12","passport_no":"Blanditiis sint acc","date_of_birth":"2015-04-22","gender":"Male","nationality":"Albanian","guardian":"{\"name\":\"Unde voluptas alias \",\"relationship\":\"Ipsam nulla est inci\",\"email\":\"irfan@gmail.com\",\"contact_no\":\"Doloribus exercitati\",\"nationality\":\"Belarusian\",\"residential_address\":\"Fugiat praesentium v\"}","guardian2":"{\"name\":\"Zahir Huber\",\"relationship\":\"asd\",\"email\":\"gugi@mailinator.com\",\"contact_no\":\"asd\",\"nationality\":\"Anguillan\",\"residential_address\":\"Ea qui irure sunt en\"}","questions":"[{\"title\":\"Hello\",\"description\":\"\",\"required\":false,\"is_heading\":true,\"answer_type\":\"\",\"options\":\"\",\"options_array\":[\"\"],\"answer\":\"\"},{\"title\":\"\",\"description\":\"\",\"required\":false,\"is_heading\":false,\"answer_type\":\"text\",\"options\":\"\",\"options_array\":[\"\"],\"answer\":\"asd\"}]","sub_total":"1000","discount":100,"discount_detail":"10% discount for sibling","net_total":900},{"program_order_id":null,"name":"Velit quisquam prae","age":"1","passport_no":"Omnis dolores sit m","date_of_birth":"1989-11-23","gender":"Female","nationality":"American Samoan","guardian":"{\"name\":\"Unde voluptas alias \",\"relationship\":\"Ipsam nulla est inci\",\"email\":\"irfan@gmail.com\",\"contact_no\":\"Doloribus exercitati\",\"nationality\":\"Belarusian\",\"residential_address\":\"Fugiat praesentium v\"}","guardian2":"{\"name\":\"Zahir Huber\",\"relationship\":\"asd\",\"email\":\"gugi@mailinator.com\",\"contact_no\":\"asd\",\"nationality\":\"Angolan\",\"residential_address\":\"Ea qui irure sunt en\"}","questions":"[{\"title\":\"Hello\",\"description\":\"\",\"required\":false,\"is_heading\":true,\"answer_type\":\"\",\"options\":\"\",\"options_array\":[\"\"]},{\"title\":\"\",\"description\":\"\",\"required\":false,\"is_heading\":false,\"answer_type\":\"text\",\"options\":\"\",\"options_array\":[\"\"],\"answer\":\"asd\"}]","sub_total":"1000","discount":100,"discount_detail":"10% discount for sibling","net_total":900}],"bookedProgram":{"program_id":3001,"group_id":2,"program_order_id":null,"title":"Nature Science: Forest Exploration Program","venue":"Taman Persekutuan Bukit Kiara, TTDI","start_date":"2023-07-18","end_date":"2023-07-19","age_group":"12-14","age_group_extra_info":"no parents allowed","price":"1000","pick_and_drop":"Pick and drop","timetable":"[]","time":null},"cart_id":"fc70dcfa-ba8c-4003-93a8-3b178b7a7586"}]';
        $existingp = json_decode($personal_laptop, true);
        // $existingp = json_decode($office_laptop, true);
        session()->put('cart_programs', $existingp);
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Resotored!']);
    }

    public function recalculatePrograms()
    {

        // Retrieving the existing array from the session
        $existingPrograms = collect(session('cart_programs', []));

        // Re-evaluate promotions so we know if there's a group discount
        // But manually calculate subtotal since calculate() might not have run yet.
        $tempSubtotal = 0;
        foreach (session('cart', []) as $p) {
            $tempSubtotal += ($p['quantity'] * $p['price']);
        }
        $tempProgramSubtotal = 0;
        foreach ($existingPrograms as $prog) {
            $tempProgramSubtotal += $prog['order']['unit_price'] * count($prog['children']);
        }

        $this->subTotal = $tempSubtotal;
        $this->programsSubTotal = $tempProgramSubtotal;
        $this->evaluatePromotions();

        // The flag is now fully controlled and centralized by the Applier
        $allowSiblingDiscount = $this->promotionsData['allow_sibling_discount'] ?? true;

        # Group by program_id
        $groupedPrograms = $existingPrograms->groupBy(function ($item) {
            return $item['order']['program_id'];
        });

        # get all the programs which are two times in cart, check by program_id
        $filteredGroups = $groupedPrograms->filter(function ($group) {
            return $group->count() > 1;
        });

        #sort the groups by unit_price, highest to lowest
        $filteredGroups = $filteredGroups->map(function ($group) {
            return $group->sortByDesc('order.unit_price');
        });

        $updatedPrograms = collect();

        foreach ($filteredGroups as $group) {
            $iteration = 1;
            foreach ($group as $programInCart) {
                $pId = $programInCart['bookedProgram']['program_id'];
                # take Full payment from the first price group
                # Apply discount on all except first price group
                $bProgramme = Program::where('id', $pId)->first();
                $subTotal = 0;
                $discount = 0;
                $vat = 0;
                $netTotal = 0;


                $count = 1;
                foreach ($programInCart['children'] as $index => $child) {
                    $child['sub_total'] = $programInCart['order']['unit_price'];
                    if ($bProgramme->type == null && ($count > 1 || $iteration > 1)) {
                        if (!$allowSiblingDiscount) {
                            $child['discount'] = 0;
                            $child['discount_detail'] = '';
                        } else {
                            $child['discount'] = (10 / 100) * $child['sub_total'];
                            $child['discount_detail'] = $child['discount'] > 0 ? '10% discount for sibling' : '';
                        }
                    } else if ($bProgramme->type == 'sevent' && ($count > 1 || $iteration > 1)) {
                        $child['discount'] = 0;
                        $child['discount_detail'] = '';
                    } else if (($bProgramme->type == 'dom' || $bProgramme->type == 'mom') && ($count > 1 || $iteration > 1)) {
                        $child['discount'] = 0;
                        $subTotal += 250;
                        $child['discount_detail'] = '';
                    } else {
                        $child['discount'] = 0;
                        $child['discount_detail'] = '';
                    }
                    $child['net_total'] = $child['sub_total'] - $child['discount'];
                    $programInCart['children'][$index] = $child;
                    $count++;
                }

                $children_collection = collect($programInCart['children']);
                $subTotal = $children_collection->sum('sub_total');
                $discount = $children_collection->sum('discount');
                $sst = 0;
                if ($programInCart['order']['sst'] > 0) {
                    $sst = ($subTotal - $discount) * (getSstValue());
                }
                $vat = 0;
                $netTotal = ($subTotal - $discount) + $vat + $sst;

                $programInCart['order']['sub_total'] = $subTotal;
                $programInCart['order']['discount'] = $discount;
                $programInCart['order']['sst'] = $sst;
                $programInCart['order']['vat'] = $vat;
                $programInCart['order']['net_total'] = $netTotal;

                $updatedPrograms = $updatedPrograms->merge(collect([$programInCart]));
                $iteration++;
            }
        }

        $existingPrograms = $existingPrograms->keyBy('cart_id');

        $updatedPrograms->each(function ($item) use ($existingPrograms) {
            $cartId = $item['cart_id'];

            // Check if the item with the same cart_id exists in ex$existingPrograms
            if ($existingPrograms->has($cartId)) {
                // Update the item in ex$existingPrograms with the item from updatedPrograms
                $existingPrograms[$cartId] = $item;
            }
        });

        // dd($existingPrograms);

        $existingPrograms = $existingPrograms->values();

        // dd($existingPrograms);

        session()->put('cart_programs', $existingPrograms);
        // save $updatedCartPrograms in session
        // $this->dispatchBrowserEvent('success-notification', ['message' => 'Recaalculated!']);
    }

    public function render()
    {
        // session()->forget('cart_programs');
        $cartPrograms = collect(session('cart_programs', []));
        // dd($cartPrograms);
        $productsFromSession = collect(session('cart'));
        if ($productsFromSession->isEmpty()) {
            $this->products = [];
        } else {
            $this->products = $productsFromSession->toArray();
            // dd($this->products);
        }
        $this->calculate();
        $cartPrograms = collect(session('cart_programs', []));
        return view('livewire.parent.cart-component', compact('cartPrograms'));
    }
}

<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ShopController;
use App\Mail\PaymentSuccessfullMail;
use App\Models\Article;
use App\Models\Order;
use App\Models\Product;
use App\Models\Program;
use App\Models\ProgramOrder;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Route;


use App\Http\Livewire\Admin\Promotion\Dashboard;
use App\Http\Livewire\Admin\Promotion\Index;
use App\Http\Livewire\Admin\Promotion\Form;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('send-camp-order-mail/{id}', function ($id) {
    $order = ProgramOrder::findOrFail($id);
    Mail::to($order->email)
        ->cc('enquiry@madabouteducation.com')
        ->bcc('shahzaib.ch2019@gmail.com')
        ->send(new PaymentSuccessfullMail($order,  'camp'));
});


Route::get('/test', function () {
    $order = Order::find('105');
    $order->generateInvoice();
    dd('done');
    return view('welcome');
});



Route::get('/publish-livewire-assets', function () {
    try {
        Artisan::call('vendor:publish', [
            '--tag' => 'livewire:assets',
        ]);
        return 'Livewire assets published successfully.';
    } catch (\Exception $e) {
        return 'Error occurred during Livewire assets publishing: ' . $e->getMessage();
    }
});

// Artisan Routes for server
Route::get('/migrate', function () {
    try {
        Artisan::call('migrate');
        return 'Migration completed successfully.';
    } catch (\Exception $e) {
        return 'Error occurred during migration: ' . $e->getMessage();
    }
});

Route::get('/clear-optimization-cache', function () {
    try {
        Artisan::call('optimize:clear');
        return 'Optimization cache cleared successfully.';
    } catch (\Exception $e) {
        return 'Error occurred during optimization cache clearing: ' . $e->getMessage();
    }
});

Route::get('/seed-countries', function () {
    try {
        Artisan::call('db:seed', [
            '--class' => 'CountrySeeder',
        ]);
        return 'Database seeding completed successfully.';
    } catch (\Exception $e) {
        return 'Error occurred during database seeding: ' . $e->getMessage();
    }
});

Route::get('/storage-link', function () {
    try {
        Artisan::call('storage:link');
        return 'Storage link created successfully.';
    } catch (\Exception $e) {
        return 'Error occurred during storage link creation: ' . $e->getMessage();
    }
});

Route::post('image-upload', [HomeController::class, 'storeImage'])->name('image.upload');

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('about-mae', 'about')->name('about_us');
    Route::get('contact-us', 'contact')->name('contact_us');
    Route::get('delivery-policy', 'deliveryPolicy')->name('delivery_policy');
    Route::get('refund-policy', 'refundPolicy')->name('refund_policy');
    Route::get('privacy-policy', 'privacyPolicy')->name('privacy_policy');
    Route::get('terms-conditions', 'termsConditions')->name('terms_conditions');
    Route::get('venue-facilities', 'venue')->name('venue');
    Route::get('health-safety', 'health')->name('health');
    Route::get('camp-preprations', 'camp')->name('camp');
    Route::get('travel-transport', 'travel')->name('travel');
    Route::get('testimonials', 'testimonials')->name('testimonials');
    Route::get('faqs', 'faqs')->name('faqs');
    Route::get('gallery', 'gallery')->name('gallery');
    Route::get('calendar', 'calendar')->name('calendar');
    Route::get('instruction', 'instruction')->name('instruction');
    Route::get('birthday-party', 'birthday')->name('birthday');
    Route::get('media', 'media')->name('media');
    Route::get('school', 'school')->name('school');
    Route::get('information', 'information')->name('information');
    Route::get('articles', function () {
        $articles = Article::active()->get();
        return view('articles.list', compact('articles'));
    })->name('articles');
    Route::get('articles/{slug}', function ($slug) {
        $article = Article::active()->where('slug', $slug)->firstOrFail();
        return view('articles.detail', compact('article'));
    })->name('article_details');
    Route::get('invoice-shop/{showView?}', 'invoiceShop')->name('invoice_shop');
    Route::get('invoice-camp/{showView?}', 'invoiceCamp')->name('invoice_camp');
    Route::get('cd/{showView?}', 'childrenDetail')->name('children_detail');
});

Route::controller(PaymentController::class)->group(function () {
    Route::get('checkout/{type}/{id}', 'checkout')->name('payment.checkout');
    Route::get('payment-processed', 'paymentProcessed')->name('payment.processed');
});
Route::controller(PaymentController::class)->group(function () {
    Route::get('checkout-ipay/{type}/{id}', 'checkoutIpay88')->name('payment.checkout-ipay');
    Route::post('ipay/response', 'iPayResponse')->name('ipay.response');
});


Route::controller(ShopController::class)->prefix('/shop')->group(function () {
    Route::get('/categories', 'categories')->name('shop.categories');
    Route::get('/', 'shop')->name('shop');
    Route::get('/cart', 'cart')->name('shop.cart');
    Route::get('/checkout-details', 'checkoutDetails')->name('shop.checkout_details')->middleware('auth');
    Route::get('/{slug}', 'productDetail')->name('shop.detail');
});

Route::controller(ProgramController::class)->group(function () {
    Route::get('/programs', 'programs')->name('programs');
    Route::get('/programs/{categorySlug}', 'programByCategory')->name('programs.category');
    Route::get('/program-checkout-details/{programId}/{groupId}', 'checkoutDetails')->name('programs.checkout_details')->middleware('auth');
    Route::get('/programs/{categorySlug}/{programSlug}', 'programsDetail')->name('programs.detail');
});

#For Logged in user
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/redirect-to-dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dashboard');
    })->name('redirect-to-dashboard');
});

#For Public User only
Route::middleware(['public_user', 'verified'])->prefix('dashboard')->group(function () {

    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/my-children', function () {
        return view('parent.children');
    })->name('my_children');
    Route::get('/my-orders', function () {
        return view('parent.my-orders');
    })->name('my_orders');
    Route::get('/my-booked-programs', function () {
        return view('parent.booked-programs');
    })->name('my_programs');
});

#For admin only
Route::middleware(['admin', 'verified'])->prefix('admin')->name('admin.')->group(function () {


    Route::prefix('promotions')->name('promotions.')->group(function () {

        Route::view('/dashboard', 'admin.promotion.dashboard')->name('dashboard');

        Route::view('/', 'admin.promotion.index')->name('index');

        Route::view('/create', 'admin.promotion.form')->name('create');
    });


    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::get('/system/roles', function () {
        return view('admin.roles');
    })->name('roles')->middleware('can:role-management');
    Route::get('/system/users', function () {
        return view('admin.users');
    })->name('users')->middleware('can:user-management');
    Route::get('/system/website-users', function () {
        return view('admin.website-users');
    })->name('website-users')->middleware('can:website-user-management');
    Route::get('/programs', function () {
        return view('admin.programs');
    })->name('programs')->middleware('can:programs-management');
    Route::get('/programs/timetables/{id}', function ($id) {
        return view('admin.programs-timetables', compact('id'));
    })->name('programs-timetables')->middleware('can:programs-management');
    Route::get('/programs/prduct-addons/{id}', function ($id) {
        return view('admin.programs-addons', compact('id'));
    })->name('programs-addons')->middleware('can:programs-management');
    Route::get('/programs/category', function () {
        return view('admin.programs-category');
    })->name('programs.category')->middleware('can:programs-management');
    Route::get('/programs/forms', function () {
        return view('admin.forms');
    })->name('forms')->middleware('can:forms-management');
    Route::get('/programs/programs-groups/{id}', function ($id) {
        $program = Program::where('id', $id)->firstOrFail();
        return view('admin.programs-groups', compact('program'));
    })->name('programs-groups')->middleware('can:programs-management');
    Route::get('/programs/bookings', function () {
        return view('admin.programs-bookings');
    })->name('program-bookings')->middleware('can:programs-management');
    Route::get('/shop/products', function () {
        return view('admin.shop.products');
    })->name('shop.products')->middleware('can:products-management');
    Route::get('/shop/orders', function () {
        return view('admin.shop.orders');
    })->name('shop.orders')->middleware('can:shop-orders-management');
    Route::get('/shop/subscriptions', function () {
        return view('admin.shop.subscriptions');
    })->name('shop.subscriptions')->middleware('can:shop-subscriptions-management');
    Route::get('shop/product-categories', function () {
        return view('admin.shop.product-categories');
    })->name('shop.product-categories');
    Route::get('/shop/subscriptions/{id}', function ($id) {
        $order = Order::findOrFail($id);
        return view('admin.shop.order-details', compact('order'));
    })->name('shop.order-details')->middleware('can:shop-orders-management');

    Route::get('/shop/products/{id}/variations', function ($id) {
        $product = Product::findOrFail($id);
        return view('admin.shop.product-variations', compact('product'));
    })->name('shop.product-variations')->middleware('can:products-management');

    Route::get('/others/gallery', function () {
        return view('admin.gallery');
    })->name('gallery')->middleware('can:gallery-management');
    Route::get('/others/media', function () {
        return view('admin.media');
    })->name('media')->middleware('can:media-management');
    Route::get('/others/articles', function () {
        return view('admin.articles');
    })->name('articles')->middleware('can:article-management');
    Route::get('/others/newsletter', function () {
        return view('admin.newsletter');
    })->name('newsletter')->middleware('can:newsletter-management');
    Route::get('/others/carousel', function () {
        return view('admin.carousel');
    })->name('carousel')->middleware('can:carousel-management');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

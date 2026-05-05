<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderMail;
use App\Models\Media;
use App\Models\Order;
use App\Models\ProgramOrder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function home()
    {
        // $order = Order::latest()->first();
        // Mail::to($order->email)->send(new NewOrderMail($order));
        $images = array_slice(getGalleryImages(), 0, 8);
        return view('home', compact('images'));
    }

    public function deliveryPolicy()
    {
        return view('delivery-policy');
    }

    public function privacyPolicy()
    {
        return view('privacy-policy');
    }

    public function termsConditions()
    {
        return view('terms-conditions');
    }

    public function refundPolicy()
    {
        return view('refund-policy');
    }

    

    public function about()
    {
        return view('about-us');
    }

    public function birthday()
    {
        return view('birthday');
    }

    public function venue()
    {
        return view('venue');
    }
    public function health()
    {
        return view('health');
    }
    public function camp()
    {
        return view('camp');
    }
    public function travel()
    {
        return view('travel');
    }


    public function contact()
    {
        return view('contact-us');
    }

    public function testimonials()
    {
        return view('testimonials');
    }

    public function faqs()
    {
        return view('faqs');
    }

    public function calendar()
    {
        return view('calendar');
    }

    public function instruction()
    {
        return view('instruction');
    }

    public function  media()
    {
        $media = Media::active()->get();
        return view('media', compact('media'));
    }

    public function school()
    {
        return view('school');
    }

    public function information()
    {
        return view('information');
    }

    public function gallery()
    {
        $images = getGalleryImages();
        return view('gallery', compact('images'));
    }

    public function storeImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('media-uploads'), $fileName);

            $url = asset('media-uploads/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
    }

    public function childrenDetail(Request $request, $showView = false)
    {
        $order = ProgramOrder::find('4');
        if (!$showView) {
            $pdf = Pdf::loadView('documents.children-details', ['order' => $order]);
            return $pdf->stream();
        }
        return view('documents.children-details', compact('order'));
    }

    public function invoiceShop(Request $request, $showView = false)
    {
        $order = Order::first();
        if (!$showView) {
            $pdf = Pdf::loadView('documents.invoice-shop', ['order' => $order]);
            return $pdf->stream();
        }
        return view('documents.invoice-shop', compact('order'));
    }

    public function invoiceCamp(Request $request, $showView = false)
    {
        $order = ProgramOrder::first();
        $order->generateInvoice();
        if (!$showView) {
            $pdf = Pdf::loadView('documents.invoice-camp', ['order' => $order]);
            return $pdf->stream();
        }
        return view('documents.invoice-camp', compact('order'));
    }
}

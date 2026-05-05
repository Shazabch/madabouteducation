<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'order_status' => OrderStatus::class,
        'payment_status' => PaymentStatus::class,
    ];

    public function getFullIdAttribute()
    {
        $originalId = $this->attributes['id'];
        $adjustedId = str_pad($originalId, 4, '0', STR_PAD_LEFT);
        $id = 'S-' . $adjustedId;
        $createdAt = new \DateTime($this->attributes['created_at']);
        $year = $createdAt->format('Y');
        $month = $createdAt->format('m');
        return "{$id}-{$year}-{$month}";
    }

    public function getRunningIdAttribute()
    {
        $originalId = $this->attributes['id'];
        $adjustedId = str_pad($originalId, 4, '0', STR_PAD_LEFT);
        return $adjustedId;
    }

    public function getFullAddressAttribute()
    {
        return collect([$this->attributes['house_name_number'], $this->attributes['street_address'], $this->attributes['postal_code'], $this->attributes['city']])->join(',', '');
    }

    public function canChangeStatus()
    {
        return $this->order_status->notIn([OrderStatus::NotPaid]);
    }

    public function generateInvoice()
    {
        $directory = 'shop_orders';
        $relatedPorgramOrders = ProgramOrder::with('bookedProgram')->where('shop_order_id', $this->id)->get();
        $pdf = Pdf::loadView('documents.invoice-shop', ['order' => $this, 'relatedPorgramOrders' => $relatedPorgramOrders]);
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }
        $filepath = 'storage/' . $directory . '/shop_order_' . $this->id . '.pdf';
        $pdf->save($filepath);
        $this->update(['invoice' => $filepath]);
    }

    public static function getOrdersByDateQuery($startDate=null,$endDate=null,$paymentStatus=null){
        $query = self::query()
        ->when($paymentStatus, function ($query, $paymentStatus) {
            return $query->where('payment_status', $paymentStatus);
        })
        ->when($startDate, function ($query, $startDate) {
            return $query->whereDate('created_at', '>=', $startDate);
        })
        ->when($endDate, function ($query, $endDate) {
            return $query->whereDate('created_at', '<=', $endDate);
        });
        return $query;
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function details()
    {
        $details = null;
        foreach ($this->items as $key => $item) {
            $details = $details . $item->name . " " . $item->price . "x" . $item->quantity . "| ";
        }
        return $details;
    }

    public function isPaid()
    {
        return $this->payment_status->is(PaymentStatus::Paid);
    }

    public function paidAt()
    {
        return $this->paid_at ? Carbon::parse($this->paid_at)->format('d-M-Y h:i a') : '';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentLabel()
    {
        return $this->payment_status->is(PaymentStatus::Paid) ? 'badge bg-success' : 'badge bg-danger';
    }

    public function programOrders(){
        return $this->hasMany(ProgramOrder::class,'shop_order_id');
    }
}

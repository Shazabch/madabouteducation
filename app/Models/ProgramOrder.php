<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ProgramOrder extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $casts=[
        'payment_status'=>PaymentStatus::class,
    ];

    public function getFullIdAttribute()
    {
        $originalId = $this->attributes['id'];
        $adjustedId = str_pad($originalId, 4, '0', STR_PAD_LEFT);
        $id = 'P-' . $adjustedId;
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

    public function isPaid(){
        return $this->payment_status->is(PaymentStatus::Paid);
    }

    public function isGeneratedByShopOrder(){
        return $this->shop_order_id !=null;
    }

    public function generateInvoice()
    {
            $directory='camp_orders';
            $pdf = Pdf::loadView('documents.invoice-camp',['order'=>$this]);
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            $filepath='storage/'.$directory.'/camp_order_'.$this->id.'.pdf';
            $pdf->save($filepath);
            $this->update(['invoice'=>$filepath]);
    }

    public function generateChildrenDetails()
    {
            $directory='children_details';
            $pdf = Pdf::loadView('documents.children-details',['order'=>$this]);
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            $filepath='storage/'.$directory.'/children_details_'.$this->id.'.pdf';
            $pdf->save($filepath);
            $this->update(['children_details'=>$filepath]);
    }

    public function children()
    {
        return $this->hasMany(ProgramOrderChildren::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function bookedProgram()
    {
        return $this->hasOne(BookedProgram::class,'program_order_id');
    }

    public function parentOrder(){
        return $this->belongsTo(Order::class,'shop_order_id');
    }
}

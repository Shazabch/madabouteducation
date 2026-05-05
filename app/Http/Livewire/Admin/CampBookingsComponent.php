<?php

namespace App\Http\Livewire\Admin;

use App\Enums\PaymentStatus;
use Livewire\Component;
use App\Models\ProgramOrder;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use ZipArchive;

class CampBookingsComponent extends Component
{
    public $startDate;
    public $endDate;
    public $paymentStatus = PaymentStatus::Paid;
    public $filterByColumn = 'created_at';
    public $selected = [];
    public bool $selectAll = false;
    public bool $triggerSelectAll = false;
    public $camps = [];
    public $selectedCamp;
    use WithPagination,WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    protected $queryString = ['paymentStatus', 'filterByColumn','selectedCamp'];

    public function mount()
    {
        $this->camps = [];
        $camps_orders = ProgramOrder::select('program_id', 'program_title')->distinct('program_title')->get();
        foreach ($camps_orders as $order) {
            $this->camps[] = [
                'id'=>$order->program_id,
                'text'=>$order->program_title
            ];
        }
    }

    public function updatingSelectAll($value)
    {
        $this->triggerSelectAll = true;
    }

    public function downloadInvoices()
    {
        $files = ProgramOrder::whereIn('id', $this->selected)->pluck('invoice');
        if (!count($files)) {
            $this->dispatchBrowserEvent('error-prompt', ['message' => 'No Invoices Found']);
            return;
        }
        $zip = new ZipArchive();
        $directory = 'zips_for_download';
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $fileName = now()->format('d_m_Y_H_i_s__') . rand(0, 10000) . '.zip';

        $path = $directory . '/' . $fileName;

        if ($zip->open(public_path($path), ZipArchive::CREATE) === true) {
            foreach ($files as $file) {
                if (file_exists(public_path($file))) {
                    $relativeNameInZipFile = basename($file);
                    $zip->addFile(public_path($file), $relativeNameInZipFile);
                }
            }
            $zip->close();
            return response()->download(public_path($path));
        } else {
            $this->dispatchBrowserEvent('error-prompt', ['message' => 'Cannot Create Zip']);
        }
    }

    public function downloadDetails()
    {
        $files = ProgramOrder::whereIn('id', $this->selected)->pluck('children_details');
        if (!count($files)) {
            $this->dispatchBrowserEvent('error-prompt', ['message' => 'No Invoices Found']);
            return;
        }
        $zip = new ZipArchive();
        $directory = 'zips_for_download';
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $fileName = now()->format('d_m_Y_H_i_s__') . rand(0, 10000) . '.zip';

        $path = $directory . '/' . $fileName;

        if ($zip->open(public_path($path), ZipArchive::CREATE) === true) {
            foreach ($files as $file) {
                if (file_exists(public_path($file))) {
                    $relativeNameInZipFile = basename($file);
                    $zip->addFile(public_path($file), $relativeNameInZipFile);
                }
            }
            $zip->close();
            return response()->download(public_path($path));
        } else {
            $this->dispatchBrowserEvent('error-prompt', ['message' => 'Cannot Create Zip']);
        }
    }

    public function regenrateInvoice($id){
        $order=ProgramOrder::find($id);
        if($order){
            $order->generateInvoice();
            $this->dispatchBrowserEvent('success-notification', ['message' => 'Invoice regenrated Successfully']);
        }else{
            $this->dispatchBrowserEvent('error-prompt', ['message' => 'Order Not Found']);
        }

    }
    public function regenrateChildDetails($id){
        $order=ProgramOrder::find($id);
        if($order){
            $order->generateChildrenDetails();
            $this->dispatchBrowserEvent('success-notification', ['message' => 'Details regenrated Successfully']);
        }else{
            $this->dispatchBrowserEvent('error-prompt', ['message' => 'Order Not Found']);
        }

    }

    public function render()
    {
        // if(!$this->startDate)
        // {
        //     $this->startDate=date("Y-m-d");
        // }

        // if(!$this->endDate)
        // {
        //     $this->endDate=date("Y-m-d");
        // }
        $query = ProgramOrder::query()
            ->when($this->paymentStatus, function ($query, $paymentStatus) {
                return $query->where('payment_status', $paymentStatus);
            })
            ->when($this->selectedCamp, function ($query, $selectedCamp) {
                return $query->where('program_id', $selectedCamp);
            })
            ->when($this->startDate, function ($query, $startDate) {
                return $query->whereDate($this->filterByColumn, '>=', $startDate);
            })
            ->when($this->endDate, function ($query, $endDate) {
                return $query->whereDate($this->filterByColumn, '<=', $endDate);
            });
        $total = $query->sum('net_total');
        $totalOrders = $query->count();
        $totalChildren = $query->sum('children_count');
        $orders = $query->orderBy('id','DESC')->paginate('10');

        if ($this->triggerSelectAll) {
            if ($this->selectAll) {
                $this->selected = array_values($query->pluck('id')->toArray());
            } else {
                $this->selected = [];
            }
            $this->triggerSelectAll = false;
        }
        return view('livewire.admin.camp-bookings-component', compact('total', 'orders', 'totalOrders', 'totalChildren'));
    }
}



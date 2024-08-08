<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class OrdersExportDilvary implements FromView ,WithStyles,WithEvents
{
    protected $request;
    

    public function __construct($request)
    {
        $this->request = $request;
    }
    public function view(): View
    {
        if ($this->request->exists('type')) {
            $from = $this->request->get('from');
            $to = $this->request->get('to');
            $user_id = $this->request->get('user_id');
            $orders = Order::where('company_id', Auth()->user()->company_id)->where('is_returned', 0)->where('work_type',$this->request->work_type);
            
            if ($from != null && $to != null) {

                  
                    $orders = $orders->whereDate('created_at', '>=', $from)
                        ->whereDate('created_at', '<=', $to);
                
            } 
            if ($user_id != null) {
                $orders->where('user_id', $user_id);
            }

            $client=User::findOrFail($user_id);
            $orders=$orders->where('status_id',$client->cost_calc_status_id)->get();


        }
        return view('exports.orders_delivery', compact('orders'));
    }

    public function quickSearch($orders, $search)
    {
        $orders = $orders->where(function ($query) use ($search) {
            $query->where('order_id', 'LIKE', '%' . $search . '%')
                ->orWhere('tracking_id', 'LIKE', '%' . $search . '%')
                ->orWhere('pickup_date', 'LIKE', '%' . $search . '%')
                ->orWhere('sender_notes', 'LIKE', '%' . $search . '%')
                ->orWhere('number_count', 'LIKE', '%' . $search . '%')
                ->orWhere('reference_number', 'LIKE', '%' . $search . '%')
                ->orWhere('receved_name', 'LIKE', '%' . $search . '%')
                ->orWhere('receved_phone', 'LIKE', '%' . $search . '%')
                ->orWhere('receved_email', 'LIKE', '%' . $search . '%')
                ->orWhere('receved_address', 'LIKE', '%' . $search . '%')
                ->orWhere('receved_address_2', 'LIKE', '%' . $search . '%')
                ->orWhere('receved_notes', 'LIKE', '%' . $search . '%')
                ->orWhere('order_contents', 'LIKE', '%' . $search . '%')
                ->orWhere('amount', 'LIKE', '%' . $search . '%')
                ->orWhere('call_count', 'LIKE', '%' . $search . '%')
                ->orWhere('whatApp_count', 'LIKE', '%' . $search . '%')
                ->orWhere('is_finished', 'LIKE', '%' . $search . '%')
                ->orWhere('amount_paid', 'LIKE', '%' . $search . '%')
                ->orWhere('order_weight', 'LIKE', '%' . $search . '%')
                ->orWhere('over_weight_price', 'LIKE', '%' . $search . '%')
                ->orWhereHas('senderCity', function ($query) use ($search) {
                    $query->where('title_ar', 'LIKE', '%' . $search . '%')->orWhere('title', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('status', function ($query) use ($search) {
                    $query->where('title_ar', 'LIKE', '%' . $search . '%')->orWhere('title', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('recevedCity', function ($query) use ($search) {
                    $query->where('title_ar', 'LIKE', '%' . $search . '%')->orWhere('title', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('store_name', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('delegate', function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%');
                });
        });
        return $orders;
    }

    public function styles(Worksheet $sheet)
    {

        return [
            // Style the first row as bold with background color

            1    => ['font' => ['bold' => true], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFF00']]],

            // Apply column width
            'A'  => ['width' => 20],
            'B'  => ['width' => 40],
        ];
    }

    public function columnFormats(): array
    {
        return [
            // 'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'F' => NumberFormat::FORMAT_NUMBER_00,

            'G' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }
}



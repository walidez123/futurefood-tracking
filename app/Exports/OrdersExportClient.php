<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class OrdersExportClient implements FromView ,WithStyles,WithEvents
{
    protected $request;
    

    public function __construct($request)
    {
        $this->request = $request;
    }
    public function view(): View
    {
        if ($this->request->exists('type'))
         {
            $from = $this->request->get('from');
            $to = $this->request->get('to');
          
            if ($this->request->type == 'ship') {
                $orders = Order::where('is_returned',0)->whereBetween('pickup_date', [$from, $to])->where('user_id', Auth()->user()->id);
            } else {
                $orders = Order::where('is_returned',0)->whereBetween('created_at', [$from, $to])->where('user_id', Auth()->user()->id);
            }
            if ($this->request->status_id !== null) {
                $orders->where('status_id', $this->request->status_id);
            }
            $orders = $orders->orderBy('updated_at', 'DESC')->get();
        } 
        else {

            if ($this->request->work_type && $this->request->status_id==null ) 
            {
                $orders = Order::where('is_returned',0)->where('user_id', Auth()->user()->id)->orderBy('order_id', 'ASC')->get();
    //             $orders = Order::where('is_returned', 0)
    // ->where('user_id', Auth()->user()->id)
    // ->where('order_id', '<=', 'OR0008939')
    // ->orderBy('order_id', 'ASC')
    // ->get();

            } else {
                $orders = Order::where('is_returned',0)->where('user_id', Auth()->user()->id)->where('status_id',$this->request->status_id)->orderBy('order_id', 'ASC')->get();


            }
        }
        // return view('exports.orders_client', compact('orders'));
        return view('exports.orders', compact('orders'));

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



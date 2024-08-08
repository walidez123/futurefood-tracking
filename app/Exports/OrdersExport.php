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


class OrdersExport implements FromView ,WithStyles,WithEvents
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
            $status_id = $this->request->get('status');
            $delegate_id = $this->request->get('delegate_id');
            $contact_status = $this->request->get('contact_status');
            $paid = $this->request->get('paid');
            $sender_city = $this->request->get('sender_city');
            $receved_city = $this->request->get('receved_city');
            $search = $this->request->get('search');
            $search_order = $this->request->get('search_order');
            $service_provider_id = $this->request->get('service_provider_id');
            $orders = Order::where('company_id', Auth()->user()->company_id)->where('is_returned', 0)->where('work_type',$this->request->work_type);
            
            if ($from != null && $to != null) {
                if ($this->request->type == 'ship') {

                    $orders = $orders->whereDate('pickup_date', '>=', $from)
                        ->whereDate('pickup_date', '<=', $to);

                } else {
                    $orders = $orders->whereDate('created_at', '>=', $from)
                        ->whereDate('created_at', '<=', $to);
                }
            } else {
                $orders = $orders->orderBy('pickup_date', 'DESC');
            }
            if ($sender_city != null) {
                $orders->where('sender_city', $sender_city);
            }

            if ($receved_city != null) {
                $orders->where('receved_city', $receved_city);
            }
            if ($user_id != null) {
                $orders->where('user_id', $user_id);
            }
            if ($status_id != null) {
                $orders->where('status_id', $status_id);
            }
            if ($contact_status != null) {
                //call_count
                if ($contact_status == 0) {
                    $orders->where('whatApp_count', 0)->where('call_count', 0);
                } else {
                    $orders->where(function ($q) {
                        $q->where(function ($q1) {
                            $q1->where('whatApp_count', 0);
                            $q1->where('call_count', '>', 0);
                        })->orWhere(function ($q2) {
                            $q2->where('whatApp_count', '>', 0);
                            $q2->where('call_count', 0);
                        });
                    });
                }
            }
            if ($paid != null) {
                if ($paid == 0) {
                    $orders->where('amount_paid', 0);
                } else {
                    $orders->where('amount_paid', 1);
                }
            }
            if ($delegate_id != null) {
                $orders->where('delegate_id', $delegate_id);
            }
            if ($service_provider_id != null) {
                $orders->where('service_provider_id', $service_provider_id);

            }
            if (isset($search) && $search != '') {
                $this->quickSearch($orders, $search)->get();
            }

            if (isset($search_order) && $search_order != '') {

                $search_order_array = array_map('trim', array_filter(explode(' ', $search_order)));

                $orders = $orders->where(function ($q) use ($search_order_array) {
                    $q->whereIn('order_id', $search_order_array);
                    $q->orWhereIn('id', $search_order_array);
                    $q->orWhereIn('reference_number', $search_order_array);
                });
            }
            $orders=$orders->orderBy('order_id', 'ASC')->get();


        }
       else if ($this->request->status != null) {
            $orders = Order::where('company_id', Auth()->user()->company_id)->where('status_id',$this->request->status)->where('is_returned', 0)->where('work_type',$this->request->work_type)->orderBy('order_id', 'ASC')->get(); 

        }else{
            $orders = Order::where('company_id', Auth()->user()->company_id)->where('is_returned', 0)->where('work_type',$this->request->work_type)->orderBy('order_id', 'ASC')->get(); 


        }
                // return view('exports.orders_client', compact('orders'));

        return view('exports.orders', compact('orders'));
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



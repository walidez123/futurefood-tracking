<?php

namespace App\Exports;

use App\Models\ClientTransactions;
use App\Models\PaletteSubscription;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class BalanceTransactionExport implements FromView,WithEvents
{
    use Exportable;
    protected $userId;
    protected $request;

    public function __construct($userId,$request)
    {
        $this->userId = $userId;
        $this->request = $request;

    }
 


    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {

        $from = $this->request->get('from');
        $to = $this->request->get('to');
        $cod=$this->request->get('cod');
        $alltransactions= ClientTransactions::orderBy('id', 'desc')->where('user_id', $this->userId)->where(function ($query) {
            $query->where('debtor', '!=', 0)
                ->orWhere('creditor', '!=', 0);
        });
                if ($from != null && $to != null) {
                    $alltransactions = $alltransactions->whereDate('created_at', '>=', $from)
                        ->whereDate('created_at', '<=', $to);
                }
                if($cod !=null)
                {
                    $alltransactions = $alltransactions->where('transaction_type_id',4);

                }
                $alltransactions = $alltransactions->orderBy('id', 'desc')->get();
                $count_creditor = $alltransactions->sum('creditor');
                $count_debtor = $alltransactions->sum('debtor');

                $count_order_creditor = $alltransactions->whereNotNull('order_id')->sum('creditor');

                $count_order_debtor = $alltransactions->whereNotNull('order_id')->sum('debtor');
                // 
                $id=$this->userId;
                $pallet_subscriptions = PaletteSubscription::whereHas('clientPackagesGoods', function ($query) use ($id) {
                    $query->where('client_id', $id);
                })->where('type', '!=' , 'receive_palette' );
                if ($from != null && $to != null) {
                    $pallet_subscriptions = $pallet_subscriptions->whereDate('created_at', '>=', $from)
                        ->whereDate('created_at', '<=', $to);
                }
                $pallet_subscriptions = $pallet_subscriptions->orderBy('id', 'desc')->get();



        return view('exports.transaction', ['cod'=>$cod,'alltransactions' => $alltransactions, 'count_creditor' => $count_creditor, 'count_debtor' => $count_debtor, 'count_order_creditor' => $count_order_creditor, 'count_order_debtor' => $count_order_debtor,'pallet_subscriptions'=>$pallet_subscriptions]);

    }
    public function map($transaction): array
    {
        return [
            $transaction->id,
            $transaction->date,
            $transaction->amount,
            // Add other transaction fields you need to export
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

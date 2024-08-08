<?php

namespace App\Exports;

use App\Models\DailyReport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DailyReportExportview implements FromView, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }

    public function view(): View
    {

        $reports = DailyReport::where('company_id', Auth()->user()->company_id)->orderBy('id', 'DESC');
        if ($this->request->exists('type')) {

            $delegate_id = $this->request->get('delegate_id');
            $client_id = $this->request->get('client_id');
            $from = $this->request->get('from');
            $to = $this->request->get('to');
            if ($this->request->delegate_id != null) {
                $reports->where('delegate_id', $this->request->delegate_id);
            }
            if ($this->request->client_id != null) {
                $reports->where('client_id', $this->request->client_id);
            }
            if ($from != null && $to != null) {
                $reports = $reports->whereDate('date', '>=', $from)
                    ->whereDate('date', '<=', $to);

            }
        }

        $reports = $reports->get();
        $Recipient = $reports->sum('Recipient');
        $Received = $reports->sum('Received');
        $Returned = $reports->sum('Returned');
        $total = $reports->sum('total');

        return view('admin.excel.index', ['reports' => $reports, 'Recipient' => $Recipient, 'Received' => $Received, 'Returned' => $Returned, 'total' => $total]);

    }
}

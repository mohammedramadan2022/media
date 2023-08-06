<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class OrdersExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Order::all();
    }

    public function headings(): array
    {
        return ['#', 'Order No', 'Status', 'Payment Status', 'Receipt Date', 'Delivery Date', 'Price', 'Tax', 'Subtotal', 'Total', 'Created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->order_no,
            $row->status,
            $row->payment_status,
            $row->start_date,
            $row->end_date,
            money($row->price),
            money($row->tax),
            money($row->subtotal),
            money($row->total),
            $row->created_at,
        ];
    }
}

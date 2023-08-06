<?php

namespace App\Exports;

use App\Models\Throwback;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class ThrowbacksExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Throwback::with('order', 'user')->get();
    }

    public function headings(): array
    {
        return ['#', 'User', 'Order No', 'Reason', 'Created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->user->full_name,
            $row->order->order_no,
            $row->reason,
            $row->created_at,
        ];
    }
}

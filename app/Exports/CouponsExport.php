<?php

namespace App\Exports;

use App\Models\Coupon;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class CouponsExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Coupon::all();
    }

    public function headings(): array
    {
        return ['#', 'Coupon Name', 'Value', 'Status', 'Expired at', 'created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            $row->value,
            $row->status ? 'مفعل' : 'معطل',
            $row->expired_at,
            $row->created_at,
        ];
    }
}

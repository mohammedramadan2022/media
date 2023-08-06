<?php

namespace App\Exports;

use App\Models\Commission;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class ReportsExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Commission::allReports()->get();
    }

    public function headings(): array
    {
        return ['#', 'doctor', 'commission', 'balance', 'created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->doctor->full_name,
            $row->total,
            $row->doctor->wallet,
            $row->created_at,
        ];
    }
}

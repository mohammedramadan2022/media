<?php

namespace App\Exports;

use App\Models\Advance;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class AdvancesExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Advance::with('admin')->get();
    }

    public function headings(): array
    {
        return ['#', 'Amount', 'Employee Name', 'Reason', 'Date', 'Created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->amount,
            $row->admin->name,
            $row->reason,
            $row->date->format('Y-m-d'),
            $row->created_at,
        ];
    }
}

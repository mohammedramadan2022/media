<?php

namespace App\Exports;

use App\Models\Vacation;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class VacationsExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Vacation::with('admin')->get();
    }

    public function headings(): array
    {
        return ['#', 'Vacation Type', 'Employee Name', 'Reason', 'Days', 'From', 'To', 'Created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->vacationType->name,
            $row->admin->name,
            $row->reason,
            $row->days,
            $row->from->format('Y-m-d'),
            $row->to->format('Y-m-d'),
            $row->created_at,
        ];
    }
}

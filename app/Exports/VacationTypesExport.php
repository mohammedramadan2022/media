<?php

namespace App\Exports;

use App\Models\VacationType;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class VacationTypesExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return VacationType::withTranslation()->get();
    }

    public function headings(): array
    {
        return ['#', 'Name', 'Status', 'created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            $row->status ? 'مفعل' : 'معطل',
            $row->created_at,
        ];
    }
}

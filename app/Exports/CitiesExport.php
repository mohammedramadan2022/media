<?php

namespace App\Exports;

use App\Models\City;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class CitiesExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return City::withTranslation()->get();
    }

    public function headings(): array
    {
        return ['#', 'Name', 'Status', 'Created at'];
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

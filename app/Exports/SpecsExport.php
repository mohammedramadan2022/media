<?php

namespace App\Exports;

use App\Models\Spec;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class SpecsExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Spec::all();
    }

    public function headings(): array
    {
        return ['#', 'Name', 'Created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            $row->created_at,
        ];
    }
}

<?php

namespace App\Exports;

use App\Models\Feature;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class FeaturesExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Feature::all();
    }

    public function headings(): array
    {
        return ['#', 'url', 'Status', 'Created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->url,
            $row->status ? 'مفعل' : 'معطل',
            $row->created_at,
        ];
    }
}

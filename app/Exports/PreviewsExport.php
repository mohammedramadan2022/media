<?php

namespace App\Exports;

use App\Models\Preview;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class PreviewsExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Preview::with('section')->get();
    }

    public function headings(): array
    {
        return ['#', 'Section', 'Status', 'Created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->section->name,
            $row->status ? 'مفعل' : 'معطل',
            $row->created_at,
        ];
    }
}

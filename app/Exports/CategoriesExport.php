<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class CategoriesExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Category::withTranslation()->get();
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

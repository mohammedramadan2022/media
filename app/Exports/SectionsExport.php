<?php

namespace App\Exports;

use App\Models\Section;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class SectionsExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Section::withTranslation()->get();
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

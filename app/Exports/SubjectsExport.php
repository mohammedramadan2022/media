<?php

namespace App\Exports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class SubjectsExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Subject::withTranslation()->get();
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

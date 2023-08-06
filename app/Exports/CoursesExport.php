<?php

namespace App\Exports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class CoursesExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Course::withTranslation()->get();
    }

    public function headings(): array
    {
        return ['#', 'Title', 'Status', 'created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->title,
            $row->status ? 'مفعل' : 'معطل',
            $row->created_at,
        ];
    }
}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};
use Spatie\Activitylog\Models\Activity;

class ActivitiesExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Activity::all();
    }

    public function headings(): array
    {
        return ['#', 'Log Name', 'Description', 'Causer', 'Subject Name', 'Created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->log_name,
            $row->description,
            $row->causer->name,
            $row->subject->name,
            $row->created_at,
        ];
    }
}

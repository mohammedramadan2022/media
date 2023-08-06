<?php

namespace App\Exports;

use App\Models\Notification;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class NotificationsExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Notification::all();
    }

    public function headings(): array
    {
        return ['#', 'Title', 'Body', 'Created At'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->title,
            $row->body,
            $row->created_at,
        ];
    }
}

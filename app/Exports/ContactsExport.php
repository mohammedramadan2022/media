<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class ContactsExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Contact::all();
    }

    public function headings(): array
    {
        return ['#', 'Phone', 'Message', 'created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->phone,
            $row->message,
            $row->created_at,
        ];
    }
}

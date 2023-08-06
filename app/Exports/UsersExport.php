<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class UsersExport extends DefaultValueBinder implements ShouldAutoSize, FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return User::all();
    }

    public function headings(): array
    {
        return ['#', 'Name', 'Country Code', 'Phone', 'Email', 'created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->full_name,
            $row->country_code,
            $row->phone,
            $row->email,
            $row->created_at,
        ];
    }
}

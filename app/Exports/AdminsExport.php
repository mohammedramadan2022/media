<?php

namespace App\Exports;

use App\Models\Admin;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class AdminsExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Admin::where('role_id', '!=', 1)->get();
    }

    public function headings(): array
    {
        return ['#', 'Name', 'Email', 'Role', 'Country Code', 'Phone', 'created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            $row->email,
            $row->role->name,
            $row->country_code,
            $row->phone,
            $row->created_at,
        ];
    }
}

<?php

namespace App\Exports;

use App\Models\Role;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class RolesExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Role::withTranslation()->get();
    }

    public function headings(): array
    {
        return ['#', 'name ar', 'name en', 'created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->translate('ar')->name,
            $row->translate('en')->name,
            $row->created_at,
        ];
    }
}

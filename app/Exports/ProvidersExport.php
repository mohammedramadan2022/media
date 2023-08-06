<?php

namespace App\Exports;

use App\Models\Provider;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class ProvidersExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Provider::all();
    }

    public function headings(): array
    {
        return ['#', 'name', 'email', 'store_name', 'identity', 'Created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            $row->email,
            $row->store_name,
            $row->identity,
            $row->status ? 'مفعل' : 'معطل',
            $row->created_at,
        ];
    }
}

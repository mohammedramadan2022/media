<?php

namespace App\Exports;

use App\Models\Demand;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class DemandsExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Demand::all();
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
            $row->created_at,
        ];
    }
}

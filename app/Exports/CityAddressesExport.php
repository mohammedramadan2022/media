<?php

namespace App\Exports;

use App\Models\CityAddress;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class CityAddressesExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return CityAddress::with('city')->get();
    }

    public function headings(): array
    {
        return ['#', 'City', 'Address', 'Status', 'created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->city->name,
            $row->address,
            $row->status ? 'مفعل' : 'معطل',
            $row->created_at,
        ];
    }
}

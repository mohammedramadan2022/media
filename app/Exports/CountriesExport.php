<?php

namespace App\Exports;

use App\Models\Country;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class CountriesExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Country::all();
    }

    public function headings(): array
    {
        return ['#', 'Country Code', 'Name Arabic', 'Name English', 'created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->country_code,
            $row->translate('ar')->name,
            $row->translate('en')->name,
            $row->created_at,
        ];
    }
}

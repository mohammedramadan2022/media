<?php

namespace App\Exports;

use App\Models\Banner;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class BannersExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Banner::all();
    }

    public function headings(): array
    {
        return ['#', 'Image Url', 'Type', 'Type ID', 'Created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->image_url,
            $row->type,
            $row->type_id,
            $row->created_at,
        ];
    }
}

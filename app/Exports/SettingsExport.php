<?php

namespace App\Exports;

use App\Models\Setting;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class SettingsExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Setting::all();
    }

    public function headings(): array
    {
        return ['#', 'Key', 'Value', 'Type', 'Input', 'Created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->key,
            $row->value,
            $row->type,
            $row->input,
            $row->created_at,
        ];
    }
}

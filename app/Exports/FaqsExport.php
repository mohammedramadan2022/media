<?php

namespace App\Exports;

use App\Models\Faq;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class FaqsExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Faq::all();
    }

    public function headings(): array
    {
        return ['#', 'Question Arabic', 'Question English', 'Answer Arabic', 'Answer English', 'Type', 'Created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->translate('ar')->question,
            $row->translate('en')->question,
            $row->translate('ar')->answer,
            $row->translate('en')->answer,
            $row->type,
            $row->created_at,
        ];
    }
}

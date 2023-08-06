<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class PaymentsExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Payment::all();
    }

    public function headings(): array
    {
        return ['#', 'User', 'Amount', 'Currency', 'Pay For', 'Transaction ID', 'created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->user->name,
            $row->amount,
            $row->currency,
            self::getModelName($row),
            $row->transaction_id,
            $row->created_at,
        ];
    }

    private static function getModelName($row): string
    {
        return last(explode('\\', $row->paymentable_type));
    }
}

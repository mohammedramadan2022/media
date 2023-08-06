<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class WalletsExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Transaction::all();
    }

    public function headings(): array
    {
        return ['#', 'Provider', 'Amount', 'Beneficiary Name', 'Bank Name', 'Account no', 'Status', 'Created At'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->provider->name,
            $row->amount,
            $row->beneficiary_name,
            $row->bank_name,
            $row->account_no,
            self::setRowAction($row->action),
            $row->created_at,
        ];
    }

    private static function setRowAction($action)
    {
        if (! $action) {
            return trans('back.new');
        } elseif ($action == 'accepted') {
            return trans('back.accepted');
        } elseif ($action == 'refused') {
            return trans('back.refused');
        } else {
            return trans('back.no-value');
        }
    }
}

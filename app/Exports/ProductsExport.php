<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\{FromCollection, WithMapping, ShouldAutoSize, WithHeadings};

class ProductsExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function collection()
    {
        return Product::with(['section', 'city', 'category'])->get();
    }

    public function headings(): array
    {
        return ['#', 'Name', 'Code', 'Price', 'Section', 'Category', 'City', 'created at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            $row->code,
            money($row->price),
            $row->section->name,
            $row->category->name,
            $row->city->name,
            $row->created_at,
        ];
    }
}

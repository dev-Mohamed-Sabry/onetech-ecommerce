<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::with('category')
            ->get()
            ->map(function ($product) {

                return [
                    'category' => $product->category?->name,
                    'name' => $product->name,
                    'price' => $product->base_price,
                    'quantity' => $product->quantity,
                    'description' => strip_tags($product->description),
                    'featured' => $product->is_featured ? 'yes' : 'no',
                    'discount_type' => $product->discount_type,
                    'discount_value' => $product->discount_value,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'category',
            'name',
            'price',
            'quantity',
            'description',
            'featured',
            'discount_type',
            'discount_value',
        ];
    }
}

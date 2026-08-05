<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel,  WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        $category = Category::where(
            'name',
            trim($row['category'])
        )->first();

        $discountType = strtolower(
            trim($row['discount_type'] ?? 'none')
        );

        $discountValue = (float) (
            $row['discount_value'] ?? 0
        );

        $isFeatured = strtolower(trim($row['featured'] ?? 'no')) === 'yes';

        $price = (float) $row['price'];

        $finalPrice = $price;

        if ($discountType === 'percent') {

            $finalPrice = $price -
                ($price * $discountValue / 100);
        } elseif ($discountType === 'fixed') {

            $finalPrice = max(
                0,
                $price - $discountValue
            );
        }

        return new Product([

            'category_id' => $category->id,

            'name' => trim($row['name']),

            'base_price' => $price,

            'quantity' => (int) $row['quantity'],

            'description' => $row['description'] ?? null,

            'is_featured' => $isFeatured,

            'discount_type' => $discountType,

            'discount_value' => $discountValue,

            'final_price' =>  $finalPrice,
        ]);
    }

    public function rules(): array
    {
        return [

            '*.category' => [
                'required',
                Rule::exists('categories', 'name'),
            ],

            '*.name' => [
                'required',
                'string',
                'max:255',
            ],

            '*.price' => [
                'required',
                'numeric',
                'min:0',
            ],

            '*.quantity' => [
                'required',
                'integer',
                'min:0',
            ],

            '*.description' => [
                'nullable',
                'string',
            ],

            '*.featured' => [
                'nullable',
                Rule::in(['yes', 'no']),
            ],

            '*.discount_type' => [
                'nullable',
                Rule::in([
                    'none',
                    'fixed',
                    'percent',
                ]),
            ],

            '*.discount_value' => [
                'nullable',
                'numeric',
                'min:0',
            ],

        ];
    }

    public function customValidationMessages()
    {
        return [

            '*.category.exists' =>
            'The selected category does not exist.',

            '*.discount_type.in' =>
            'Discount type must be none, fixed or percent.',

            '*.featured.in' =>
            'Featured must be yes or no.',
        ];
    }
}

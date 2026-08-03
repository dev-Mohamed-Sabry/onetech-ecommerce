<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        $category = Category::where(
            'name',
            trim($row['category'])
        )->first();

        if (!$category) {

            throw new \Exception(
                "Category '{$row['category']}' not found"
            );
        }

        return new Product([

            'category_id' => $category->id,

            'name' => $row['name'],

            'base_price' => $row['price'],

            'quantity' => $row['quantity'],

            'description' => $row['description'],

            'is_featured' => strtolower(
                trim($row['featured'] ?? 'no')
            ) === 'yes',

            'discount_type' => 'none',

            'discount_value' => 0,

            'final_price' => $row['price'],
        ]);
    }
}

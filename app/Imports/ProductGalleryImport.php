<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Symfony\Component\HttpFoundation\File\File;

class ProductGalleryImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use Importable, SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    // public function model(array $row)
    // {
    //     $validator = Validator::make($row, [
    //         'products_id' => [
    //             'required',
    //             Rule::exists('products', 'id'),
    //         ],
    //         'url' => [
    //             'required',
    //             'url',
    //         ]
    //     ], $this->customValidationMessages());

    //     if ($validator->fails()) {
    //         throw new \Exception($validator->errors()->first() ?? 'Validation Error!');
    //     }

    //     $product = Product::findOrFail($row['products_id']);

    //     $extension = pathinfo($row['url'], PATHINFO_EXTENSION);
    //     $filename = hash('sha256', time()) . '.' . $extension;
    //     $path = Storage::putFileAs('public/gallery', $row['url'], $filename);

    //     return new ProductGallery([
    //         'products_id' => $product->id,
    //         'url' => $path
    //     ]);
    // }

    public function model(array $row)
    {
        $validator = Validator::make($row, [
            'products_id' => [
                'required',
                Rule::exists('products', 'id'),
            ],
            'url' => [
                'required',
            ]
        ], $this->customValidationMessages());

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first() ?? 'Validation Error!');
        }

        $product = Product::findOrFail($row['products_id']);

        $extension = pathinfo($row['url'], PATHINFO_EXTENSION);
        $filename = hash('sha256', time()) . '.' . $extension;
        // $location = 'public/gallery';
        $path = Storage::putFileAs('public/gallery', $row['url'], $filename);

        // $url = asset(Storage::url($path));
        $url = $path;

        return new ProductGallery([
            'products_id' => $product->id,
            'url' => $url
        ]);
    }


    public function rules(): array
    {
        return [
            'products_id' => 'required|integer',
            'url' => 'required|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'products_id.required' => 'Product ID must be provided',
            'products_id.integer' => 'Product ID must be an integer',
            'url.required' => 'Image URL must be provided',
            'url.string' => 'Image URL must be a string',
        ];
    }

    public function onError(\Throwable $e)
    {
        return back()->withError($e->getMessage());
    }
}

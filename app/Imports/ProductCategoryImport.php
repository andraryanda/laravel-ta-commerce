<?php

namespace App\Imports;

use App\Models\ProductCategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow; //d

class ProductCategoryImport implements ToModel, WithHeadingRow
{
    private const REQUIRED_HEADER_NAME = 'name'; // nama header yang diinginkan

    /**
     * @inheritDoc
     */
    public function headingRow(): int
    {
        return 1; // baris pertama di Excel berisi header
    }

    /**
     * @inheritDoc
     */
    public function model(array $row)
    {
        // memeriksa apakah header memiliki nama yang diinginkan
        if (!isset($row[self::REQUIRED_HEADER_NAME])) {
            throw new \Exception(sprintf('Nama kolom harus "%s"', self::REQUIRED_HEADER_NAME));
        }

        // proses membuat model dan validasi data lainnya
        $validator = Validator::make($row, [
            self::REQUIRED_HEADER_NAME => 'required|string|unique:product_categories,name',
        ], $this->customValidationMessages());

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first() ?? 'Validation Error!');
        }

        return new ProductCategory([
            'name' => $row[self::REQUIRED_HEADER_NAME],
        ]);
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            // definisikan pesan error yang akan ditampilkan jika validasi gagal
            self::REQUIRED_HEADER_NAME . '.required' => 'Kolom ' . self::REQUIRED_HEADER_NAME . ' tidak boleh kosong',
            self::REQUIRED_HEADER_NAME . '.string' => 'Kolom ' . self::REQUIRED_HEADER_NAME . ' harus berupa teks',
            self::REQUIRED_HEADER_NAME . '.unique' => 'Kategori sudah digunakan oleh sistem',
        ];
    }
}

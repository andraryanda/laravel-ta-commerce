<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Transaction;
use Faker\Factory as Faker;
use App\Models\ProductCategory;
use App\Models\TransactionItem;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // public function run()
    // {
    //     $faker = Faker::create();
    //     for ($i = 0; $i < 10; $i++) {
    //         $lastTransaction = Transaction::orderBy('incre_id', 'desc')->first();
    //         $increId = $lastTransaction ? $lastTransaction->incre_id + 1 : 1;
    //         $transaction = Transaction::create([
    //             'id' => $faker->uuid,
    //             'incre_id' => $increId,
    //             'users_id' => $faker->numberBetween(1, 10),
    //             'address' => $faker->address,
    //             'total_price' => $faker->numberBetween(100000, 500000),
    //             'shipping_price' => $faker->numberBetween(10000, 50000),
    //             'status' => $faker->randomElement(['PENDING', 'SUCCESS', 'CANCELLED']),
    //         ]);
    //         for ($j = 0; $j < rand(1, 5); $j++) {
    //             TransactionItem::create([
    //                 'id' => $faker->uuid,
    //                 'incre_id' => $increId,
    //                 'users_id' => $faker->numberBetween(1, 10),
    //                 'products_id' => $faker->numberBetween(1, 50),
    //                 'transactions_id' => $transaction->id,
    //                 'quantity' => $faker->numberBetween(1, 10),
    //             ]);
    //         }
    //     }
    // }

    public function run()
    {
        $faker = Faker::create();
        $categories = ProductCategory::all();
        $products = Product::all();
        for ($i = 0; $i < 10; $i++) {
            $lastTransaction = Transaction::orderBy('incre_id', 'desc')->first();
            $increId = $lastTransaction ? $lastTransaction->incre_id + 1 : 1;
            $transaction = new Transaction;
            $transaction->id = $faker->uuid;
            $transaction->incre_id = $increId;
            $transaction->users_id = $faker->numberBetween(1, 10);
            $transaction->address = $faker->address;
            $transaction->total_price = $faker->numberBetween(100000, 500000);
            $transaction->shipping_price = $faker->numberBetween(10000, 50000);
            $transaction->status = $faker->randomElement(['PENDING', 'SUCCESS', 'CANCELLED']);
            $transaction->save();
            for ($j = 0; $j < rand(1, 5); $j++) {
                $product = $products->random();
                $category = $categories->random();
                $transactionItem = new TransactionItem;
                $transactionItem->id = $faker->uuid;
                $transactionItem->incre_id = $increId;
                $transactionItem->users_id = $faker->numberBetween(1, 10);
                $transactionItem->products_id = $product->id;
                $transactionItem->transactions_id = $transaction->id;
                $transactionItem->quantity = $faker->numberBetween(1, 10);
                $transactionItem->save();
            }
        }
    }
}

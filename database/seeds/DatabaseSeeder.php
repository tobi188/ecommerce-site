<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('navbar')->insert([
            ['id' => 3,'name' => 'ゲーム機', 'parent_id' => 0 ],
            ['id' => 4,'name' => 'iPhone', 'parent_id' => 1 ],
            ['id' => 5,'name' => 'サムスン', 'parent_id' => 1 ],
            ['id' => 6,'name' => 'Google', 'parent_id' => 1 ],
            ['id' => 7,'name' => 'Sony', 'parent_id' => 1 ],
            ['id' => 8,'name' => 'MacBook', 'parent_id' => 2 ],
            ['id' => 9,'name' => 'Dell', 'parent_id' => 2 ],
            ['id' => 10,'name' => 'NEC', 'parent_id' => 2 ],
            ['id' => 11,'name' => '富士通', 'parent_id' => 2 ],
            ['id' => 12,'name' => 'PlayStation', 'parent_id' => 3 ],
            ['id' => 13,'name' => 'Xbox', 'parent_id' => 3 ],
            ['id' => 14,'name' => 'Nintendo', 'parent_id' => 3 ],
            ['id' => 15,'name' => 'iPhone 12 Pro Max 128GB', 'parent_id' => 4 ],
            ['id' => 16,'name' => 'iPhone 12 Pro 512GB', 'parent_id' => 4 ],
            ['id' => 17,'name' => 'iPhone 12 64GB', 'parent_id' => 4 ],
            ['id' => 18,'name' => 'Samsung Galaxy Note 20', 'parent_id' => 5 ],
            ['id' => 19,'name' => 'Google Pixel 5', 'parent_id' => 6 ],
            ['id' => 20,'name' => 'Xperia 5 II', 'parent_id' => 7 ]
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(App\Models\User\User::class, 5)->create();
        factory(App\Models\Item\Item::class, 40)->create();
        factory(App\Models\Item\ItemOption::class, 100)->create();
        factory(App\Models\Item\ItemAnnouncement::class, 100)->create();
        factory(App\Models\Conduction\Banner::class, 10)->create();
        factory(App\Models\Conduction\Recommand::class, 10)->create();
    }
}

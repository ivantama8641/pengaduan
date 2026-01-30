<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin Telkom',
            'email' => 'admin@telkom.sch.id',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Guru BK',
            'email' => 'guru@telkom.sch.id',
            'role' => 'teacher',
        ]);
        
        $categories = ['Sarana Prasarana', 'Kesiswaan', 'Kurikulum', 'Keamanan', 'Lainnya'];
        foreach($categories as $cat) {
            Category::create([
                'name' => $cat,
                'slug' => \Illuminate\Support\Str::slug($cat)
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\ContactCategory;
use Illuminate\Database\Seeder;

class ContactCategorySeeder extends Seeder
{
    /**
     * Seed a starter set of contact categories.
     *
     * The names are visible to the admin in the UI, so they are kept in PT.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Lead', 'color' => 'orange'],
            ['name' => 'Orçamento', 'color' => 'blue'],
            ['name' => 'Suporte', 'color' => 'purple'],
            ['name' => 'Spam', 'color' => 'red'],
        ];

        foreach ($categories as $category) {
            ContactCategory::firstOrCreate(
                ['name' => $category['name']],
                ['color' => $category['color']],
            );
        }
    }
}

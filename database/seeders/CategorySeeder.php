<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technical Support',
                'description' => 'Issues related to technical problems, bugs, or system errors'
            ],
            [
                'name' => 'Account & Billing',
                'description' => 'Questions about account management, billing, and payments'
            ],
            [
                'name' => 'General Inquiry',
                'description' => 'General questions and information requests'
            ],
            [
                'name' => 'Feature Request',
                'description' => 'Suggestions for new features or improvements'
            ],
            [
                'name' => 'Bug Report',
                'description' => 'Reports of software bugs or unexpected behavior'
            ],
            [
                'name' => 'Training & Documentation',
                'description' => 'Questions about how to use features or request for documentation'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
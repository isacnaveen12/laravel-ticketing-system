<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technical Support',
                'description' => 'Issues related to software, hardware, or technical problems'
            ],
            [
                'name' => 'Billing & Payment',
                'description' => 'Questions about billing, payments, invoices, or account charges'
            ],
            [
                'name' => 'Account Management',
                'description' => 'Account settings, profile updates, or access issues'
            ],
            [
                'name' => 'Feature Request',
                'description' => 'Suggestions for new features or improvements'
            ],
            [
                'name' => 'Bug Report',
                'description' => 'Report software bugs or unexpected behavior'
            ],
            [
                'name' => 'General Inquiry',
                'description' => 'General questions or information requests'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
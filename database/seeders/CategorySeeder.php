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
                'slug' => 'technical-support',
                'description' => 'Issues related to software, hardware, and technical problems',
                'color' => '#dc3545',
                'sort_order' => 1,
            ],
            [
                'name' => 'Billing & Payments',
                'slug' => 'billing-payments',
                'description' => 'Questions about billing, payments, and account charges',
                'color' => '#28a745',
                'sort_order' => 2,
            ],
            [
                'name' => 'Account Management',
                'slug' => 'account-management',
                'description' => 'Account settings, profile changes, and access issues',
                'color' => '#007bff',
                'sort_order' => 3,
            ],
            [
                'name' => 'Feature Requests',
                'slug' => 'feature-requests',
                'description' => 'Suggestions for new features and improvements',
                'color' => '#6f42c1',
                'sort_order' => 4,
            ],
            [
                'name' => 'General Inquiry',
                'slug' => 'general-inquiry',
                'description' => 'General questions and other inquiries',
                'color' => '#6c757d',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
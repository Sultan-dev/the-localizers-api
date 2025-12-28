<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Card;
use App\Models\Legislation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@localizer.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Sample Cards
        Card::create([
            'title' => 'خبير تقييم العروض',
            'subtitle' => 'جهة حكومية',
            'description' => 'خبير متخصص في تقييم العروض للمنافسات وفق متطلبات المحتوى المحلي وأنظمة المنافسات والمشتريات الحكومية، ويقدم الدعم في تحديد آليات المحتوى المحلي المناسبة لكل عملية ومشتريات.',
            'link' => '/expert/offer-evaluation',
            'badge' => 'جهة حكومية',
            'preview_url' => 'https://via.placeholder.com/400x200/EBFBF5/018755?text=Offer+Evaluation+Interface',
            'is_coming_soon' => false,
            'order' => 1,
            'is_active' => true,
        ]);

        Card::create([
            'title' => 'خبير القائمة الإلزامية',
            'subtitle' => 'جهة حكومية',
            'description' => 'خبير متخصص في التحقق من المنتجات المدرجة ضمن القائمة الإلزامية، ومعالجة الاستثناءات وفق الآلية المعتمدة، مع تزويدك بنبذة شاملة عن المنتجات وطريقة تسليمها.',
            'link' => '/expert/mandatory-list',
            'badge' => 'جهة حكومية',
            'preview_url' => 'https://via.placeholder.com/400x200/EBFBF5/018755?text=Mandatory+List+Interface',
            'is_coming_soon' => false,
            'order' => 2,
            'is_active' => true,
        ]);

        Card::create([
            'title' => 'الخبير العام للمحتوي المحلي',
            'subtitle' => 'جهة حكومية',
            'description' => 'خبير عام في المحتوى المحلي، يقدم إجابات دقيقة وشاملة عن جميع المتطلبات، اللوائح، الأرقام، والتشريعات المتعلقة بالمحتوى المحلي.',
            'link' => '/expert/general',
            'badge' => 'جهة حكومية',
            'preview_url' => 'https://via.placeholder.com/400x200/EBFBF5/018755?text=Chat+Interface',
            'is_coming_soon' => false,
            'order' => 3,
            'is_active' => true,
        ]);

        // Create Sample Legislations
        Legislation::create([
            'title' => 'قانون العمل',
            'type' => 'قانون',
            'description' => 'قانون ينظم علاقات العمل بين العمال وأصحاب العمل',
            'date' => '2024-01-15',
            'number' => '12/2024',
            'status' => 'نشط',
        ]);

        Legislation::create([
            'title' => 'مرسوم الضرائب',
            'type' => 'مرسوم',
            'description' => 'مرسوم يتعلق بفرض الضرائب على الشركات',
            'date' => '2024-02-20',
            'number' => '5/2024',
            'status' => 'نشط',
        ]);
    }
}


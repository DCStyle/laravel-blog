<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Công nghệ', 'backgroundColor' => '#3498db', 'textColor' => '#ffffff'],
            ['name' => 'Du lịch', 'backgroundColor' => '#2ecc71', 'textColor' => '#ffffff'],
            ['name' => 'Ẩm thực', 'backgroundColor' => '#e74c3c', 'textColor' => '#ffffff'],
            ['name' => 'Thời trang', 'backgroundColor' => '#9b59b6', 'textColor' => '#ffffff'],
            ['name' => 'Sức khỏe và Thể hình', 'backgroundColor' => '#27ae60', 'textColor' => '#ffffff'],
            ['name' => 'Khoa học', 'backgroundColor' => '#3498db', 'textColor' => '#ffffff'],
            ['name' => 'Giải trí', 'backgroundColor' => '#e67e22', 'textColor' => '#ffffff'],
            ['name' => 'Phong cách sống', 'backgroundColor' => '#f39c12', 'textColor' => '#ffffff'],
            ['name' => 'Kinh doanh và Tài chính', 'backgroundColor' => '#34495e', 'textColor' => '#ffffff'],
            ['name' => 'Giáo dục', 'backgroundColor' => '#16a085', 'textColor' => '#ffffff'],
            ['name' => 'Thể thao', 'backgroundColor' => '#e74c3c', 'textColor' => '#ffffff'],
            ['name' => 'Âm nhạc', 'backgroundColor' => '#2980b9', 'textColor' => '#ffffff'],
            ['name' => 'Nghệ thuật và Thiết kế', 'backgroundColor' => '#8e44ad', 'textColor' => '#ffffff'],
            ['name' => 'Tự làm (DIY)', 'backgroundColor' => '#d35400', 'textColor' => '#ffffff'],
            ['name' => 'Trò chơi', 'backgroundColor' => '#c0392b', 'textColor' => '#ffffff'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'backgroundColor' => $category['backgroundColor'],
                'textColor' => $category['textColor'],
            ]);
        }
    }
}

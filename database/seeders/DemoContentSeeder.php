<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'title'        => 'Dasar-dasar Pemrograman Web',
                'description'  => "Kenali cara kerja web dan bangun halaman pertamamu.\nCocok untuk pemula yang belum pernah membuat website.",
                'is_published' => true,
                'lessons'      => [
                    'Pengenalan Web dan Internet' => 'Bagaimana browser, server, dan internet saling berkomunikasi.',
                    'Struktur Dasar HTML'         => 'Tag, atribut, dan kerangka sebuah halaman HTML.',
                    'Mengenal CSS'                => 'Memberi warna, ukuran, dan tata letak pada halaman.',
                    'Dasar JavaScript'            => 'Variabel, fungsi, dan interaksi sederhana di browser.',
                ],
            ],
            [
                'title'        => 'Pengantar Framework Laravel',
                'description'  => "Pelajari fondasi Laravel: routing, controller, view, dan database.\nDisusun bertahap dari instalasi hingga aplikasi CRUD sederhana.",
                'is_published' => true,
                'lessons'      => [
                    'Instalasi dan Struktur Proyek' => 'Memasang Laravel dan mengenal folder-folder utamanya.',
                    'Routing dan Controller'        => 'Menghubungkan URL ke logika aplikasi.',
                    'Blade Template'                => 'Membuat tampilan yang dinamis dan rapi.',
                    'Eloquent dan Migration'        => 'Mengelola tabel dan data lewat model.',
                ],
            ],
            [
                'title'        => 'Dasar Basis Data MySQL',
                'description'  => 'Course ini masih berstatus draft dan belum terlihat oleh student.',
                'is_published' => false,
                'lessons'      => [
                    'Pengenalan Basis Data' => 'Konsep tabel, baris, kolom, dan relasi.',
                    'Perintah SQL Dasar'    => 'SELECT, INSERT, UPDATE, dan DELETE.',
                ],
            ],
        ];

        foreach ($data as $item) {
            $course = Course::firstOrCreate(
                ['title' => $item['title']],
                ['description' => $item['description'], 'is_published' => $item['is_published']]
            );

            $position = 1;
            foreach ($item['lessons'] as $title => $description) {
                // course_id dan position tidak ada di $fillable, jadi diisi satu per satu
                $lesson = Lesson::where('course_id', $course->id)->where('title', $title)->first()
                    ?? new Lesson();

                $lesson->course_id   = $course->id;
                $lesson->title       = $title;
                $lesson->description = $description;
                $lesson->position    = $position++;
                $lesson->save();
            }
        }
    }
}

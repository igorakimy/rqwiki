<?php

namespace Database\Seeders;

use App\Models\Element;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ElementSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     * @throws FileNotFoundException
     */
    public function run(): void
    {
        $elementsFile = resource_path('data/elements.json');

        $elements = File::json($elementsFile);

        foreach ($elements as $element) {
            Element::create([
                'name' => $element['name'],
                'vulnerable_id' => null,
            ]);
        }

        foreach ($elements as $element) {
            $elementModel = Element::where('name', $element['name'])->first();
            $elementModel->vulnerable_id = $element['vulnerable_id'];
            $elementModel->save();
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class ImageSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     * @throws FileCannotBeAdded
     */
    public function run(): void
    {
        for($i = 0; $i < 10; $i++) {
            /** @var Image $image */
            $image = Image::factory()->create();

            $image->addMediaFromUrl('https://picsum.photos/300/200')
                ->toMediaCollection();
        }
    }
}

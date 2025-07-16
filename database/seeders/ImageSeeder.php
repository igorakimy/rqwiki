<?php

namespace Database\Seeders;

use App\Enums\MediaCollectionEnum;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
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
        $imagesFilePath = resource_path('images');

        $locationsImagesFilePath = $imagesFilePath . '/locations';

        $locationsImagesFiles = File::allFiles($locationsImagesFilePath);

        foreach ($locationsImagesFiles as $locationsImagesFile) {
            $name = Str::replace(
                '_',
                ' ',
                Str::remove('.png', $locationsImagesFile->getFilename())
            );

            $image = Image::create([
                'name' => $name,
            ]);

            $image->addMedia($locationsImagesFile)
                ->preservingOriginal()
                ->toMediaCollection(MediaCollectionEnum::LOCATIONS->value);
        }
    }
}

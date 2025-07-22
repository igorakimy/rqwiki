<?php

namespace Database\Seeders;

use App\Enums\MediaCollectionEnum;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

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

        $this->createLocationImages($imagesFilePath);
        $this->createLocationBackgroundImage($imagesFilePath);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function createLocationImages(string $path): void
    {
        $locationsImagesFiles = File::allFiles($path . '/locations');

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

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function createLocationBackgroundImage(string $path): void
    {
        $locationsBgImagesFiles = File::allFiles($path . '/location_bg');

        if (isset($locationsBgImagesFiles[0])) {
            $file = $locationsBgImagesFiles[0];
            $name = Str::ucfirst(Str::replace('_', ' ', $file->getFilenameWithoutExtension()));
            $image = Image::create([
                'name' => $name,
            ]);
            $image->addMedia($file)
                ->preservingOriginal()
                ->toMediaCollection(MediaCollectionEnum::LOCATIONS->value);
        }
    }
}

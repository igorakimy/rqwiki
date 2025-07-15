<?php

namespace App\Http\Controllers\Images;

use App\Enums\MediaCollectionEnum;
use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $perPage = $request->input('per_page', 10);
        $sortField = $request->input('sort_field', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
        $name = $request->input('name');

        $query = Image::query()->with('media');

        if ($request->filled('name')) {
            $query->whereLike('name', '%' . $name . '%', boolean: 'or');
        }

        $images = $query->orderBy($sortField, $sortDirection)
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render('images/Index', [
            'images' => $images->items(),
            'pagination' => [
                'current_page' => $images->currentPage(),
                'per_page' => $images->perPage(),
                'total' => $images->total(),
                'last_page' => $images->lastPage(),
            ],
            'filters' => [
                ['name' => $name],
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $mediaCollections = collect(MediaCollectionEnum::cases())->map(function ($item) {
            return [
                'name' => $item->value,
                'translated_name' => $item->translate(),
            ];
        });

        return Inertia::render('images/Create', [
            'media_collections' => $mediaCollections,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @throws FileIsTooBig|FileDoesNotExist
     */
    public function store(Request $request)
    {
        $validData = $request->validate([
            'name' => 'required|string',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'media_collection' => [
                'required',
                Rule::enum(MediaCollectionEnum::class),
            ],
        ]);

        $image = Image::create([
            'name' => $validData['name'],
        ]);

        $image->addMedia($validData['file'])
            ->toMediaCollection($validData['media_collection']);

        return to_route('images.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        $mediaCollections = collect(MediaCollectionEnum::cases())->map(function ($item) {
            return [
                'name' => $item->value,
                'translated_name' => $item->translate(),
            ];
        });

        $image = $image->load('media');

        return Inertia::render('images/Edit', [
            'image' => $image,
            'media_collections' => $mediaCollections,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @throws FileDoesNotExist|FileIsTooBig
     */
    public function update(Request $request, Image $image)
    {
        $validData = $request->validate([
            'name' => 'required|string',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'media_collection' => [
                'required',
                Rule::enum(MediaCollectionEnum::class),
            ],
        ]);

        $image->update([
            'name' => $validData['name'],
        ]);

        if ($request->hasFile('file')) {
            $image->clearMediaCollection('*');
            $image->addMedia($validData['file'])
                ->toMediaCollection($validData['media_collection']);
        }

        if (!$request->hasFile('file') && $request->has('media_collection')) {
            $image->getFirstMedia('*')->update([
                'collection_name' => $validData['media_collection'],
            ]);
        }

        return to_route('images.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        $image->delete();

        return to_route('images.index');
    }
}

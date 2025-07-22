<?php

namespace App\Http\Controllers\Locations;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Models\Location;
use App\Models\LocationType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $perPage = $request->input('per_page', 10);
        $sortField = $request->input('sort_field', 'name');
        $sortDirection = $request->input('sort_direction', 'asc');
        $name = $request->input('name');

        $query = Location::query()->with([
            'image',
            'image.media',
            'location_types'
        ]);

        if ($request->filled('name')) {
            $query->whereLike('name', '%' . $name . '%', boolean: 'or');
        }

        if ($sortField == 'name') {
            $query->orderBy('name', $sortDirection);
        }

        $locations = $query->paginate($perPage)
            ->withQueryString();

        return Inertia::render('locations/Index', [
            'locations' => $locations->items(),
            'pagination' => [
                'total' => $locations->total(),
                'per_page' => $locations->perPage(),
                'current_page' => $locations->currentPage(),
                'last_page' => $locations->lastPage(),
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
        $images = Image::with('media')->get();
        $locationTypes = LocationType::select(['id', 'name'])->get();
        $categories = Category::select(['id', 'name'])->get();

        return Inertia::render("locations/Create", [
            'images' => $images,
            'location_types' => $locationTypes,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|unique:locations|max:255',
            'image_id' => 'required|exists:images,id',
            'location_types' => 'required|array|min:1',
            'categories' => 'required|array|min:1',
            'categories.*.id' => 'required|exists:categories,id',
            'description' => 'nullable',
        ]);

        $location = Location::create([
            'name' => $validated['name'],
            'image_id' => $validated['image_id'],
            'description' => $validated['description'],
        ]);

        $location->location_types()->sync($validated['location_types']);
        $location->categories()->sync(collect($validated['categories'])->pluck('id'));

        return to_route("locations.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location): Response
    {
        $backgroundImage = Image::where('name', 'Фон локации')
            ->with('media')
            ->first();

        $location = $location->load([
            'image',
            'image.media',
            'location_types'
        ]);

        return Inertia::render('locations/Show', [
            'location' => $location,
            'bg_image' => $backgroundImage,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location): Response
    {
        $images = Image::with('media')->get();
        $locationTypes = LocationType::select(['id', 'name'])->get();
        $categories = Category::select(['id', 'name'])->get();

        return Inertia::render("locations/Edit", [
            'location' => $location->load(['image', 'image.media', 'location_types', 'categories']),
            'images' => $images,
            'location_types' => $locationTypes,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('locations', 'name')->ignore($location->id),
            ],
            'image_id' => 'required|exists:images,id',
            'location_types' => 'required|array|min:1',
            'categories' => 'required|array|min:1',
            'categories.*.id' => 'exists:categories,id',
            'description' => 'nullable',
        ]);

        $location->update([
            'name' => $validated['name'],
            'image_id' => $validated['image_id'],
            'description' => $validated['description'],
        ]);

        $location->location_types()->sync($validated['location_types']);
        $location->categories()->sync(collect($validated['categories'])->pluck('id'));

        return to_route("locations.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        $location->delete();

        return to_route('locations.index');
    }
}

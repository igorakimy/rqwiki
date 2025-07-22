<?php

namespace App\Http\Controllers\Locations;

use App\Http\Controllers\Controller;
use App\Models\LocationType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class LocationTypeController extends Controller
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

        $query = LocationType::query();

        if ($request->filled('name')) {
            $query->whereLike('name', '%' . $name . '%', boolean: 'or');
        }

        $locationTypes = $query->orderBy($sortField, $sortDirection)
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render('location_types/Index', [
            'location_types' => $locationTypes->items(),
            'pagination' => [
                'current_page' => $locationTypes->currentPage(),
                'per_page' => $locationTypes->perPage(),
                'total' => $locationTypes->total(),
                'last_page' => $locationTypes->lastPage(),
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
        return Inertia::render('location_types/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validData = $request->validate([
            'name' => 'required|min:6|max:255|unique:location_types,name',
            'plural_name' => 'required|min:6|max:255',
            'description' => 'nullable|min:10|max:255',
        ]);

        LocationType::create($validData);

        return to_route('location-types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(LocationType $locationType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LocationType $locationType): Response
    {
        return Inertia::render('location_types/Edit', [
            'location_type' => $locationType
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LocationType $locationType): RedirectResponse
    {
        $validData = $request->validate([
            'name' => [
                'required',
                'min:6',
                'max:255',
                Rule::unique('location_types', 'name')
                    ->ignore($locationType->id),
            ],
            'plural_name' => 'required|min:6|max:255',
            'description' => 'nullable|min:10|max:255',
        ]);

        $locationType->update($validData);

        return to_route('location-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LocationType $locationType): RedirectResponse
    {
        $locationType->delete();

        return to_route('location-types.index');
    }
}

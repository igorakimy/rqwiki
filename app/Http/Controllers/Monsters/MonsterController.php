<?php

namespace App\Http\Controllers\Monsters;

use App\Enums\MonsterDefenceEnum;
use App\Enums\MonsterModeEnum;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Element;
use App\Models\Image;
use App\Models\Location;
use App\Models\Monster;
use App\Models\Race;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class MonsterController extends Controller
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

        $query = Monster::with([
            'element',
            'element.image.media',
            'race',
            'race.image.media',
            'image',
            'image.media',
            'locations',
        ]);

        if ($request->filled('name')) {
            $query->whereLike('monsters.name', '%' . $name . '%', boolean: 'or');
        }

        if (in_array($sortField, ['name', 'level', 'health_points', 'experience', 'xp_per_hp'])) {
            $query->orderBy($sortField, $sortDirection);
        }

        if ($sortField === 'element') {
            $query->orderByLeftPowerJoins('element.name', $sortDirection);
            $query->orderBy('element_strength', $sortDirection);
        }

        if ($sortField === 'race') {
            $query->orderByLeftPowerJoins('race.name', $sortDirection);
        }

        $monsters = $query->paginate($perPage)
            ->withQueryString();

        return Inertia::render('monsters/Index', [
            'monsters' => $monsters->items(),
            'pagination' => [
                'total' => $monsters->total(),
                'per_page' => $monsters->perPage(),
                'current_page' => $monsters->currentPage(),
                'last_page' => $monsters->lastPage(),
            ],
            'filters' => [
                ['name' => $name]
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $images = Image::with('media')->get();
        $races = Race::with('image', 'image.media')->get();
        $elements = Element::with('image', 'image.media')->get();
        $defenceTypes = MonsterDefenceEnum::values();
        $combatModes = MonsterModeEnum::values();
        $categories = Category::select(['id', 'name'])->get();
        $locations = Location::select(['id', 'name'])->get();

        return Inertia::render('monsters/Create', [
            'images' => $images,
            'races' => $races,
            'elements' => $elements,
            'defence_types' => $defenceTypes,
            'combat_modes' => $combatModes,
            'categories' => $categories,
            'locations' => $locations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:monsters',
            'level' => 'required|min:1|max:70',
            'health_points' => 'required|numeric|min:1',
            'element_id' => 'required|exists:elements,id',
            'element_strength' => 'required|numeric|min:1',
            'race_id' => 'required|exists:races,id',
            'is_aggressive' => 'required|boolean',
            'is_elite' => 'required|boolean',
            'is_boss' => 'required|boolean',
            'pick_up_loot' => 'required|boolean',
            'shield' => 'nullable|numeric|min:0',
            'experience' => 'required|numeric|min:0',
            'xp_per_hp' => 'required|numeric|min:0',
            'defence' => [
                'required',
                Rule::enum(MonsterDefenceEnum::class),
            ],
            'combat_mode' => [
                'required',
                Rule::enum(MonsterModeEnum::class),
            ],
            'quest_only' => 'required|boolean',
            'image_id' => 'required|exists:images,id',
            'locations' => 'required|array',
            'locations.*.id' => 'required|exists:locations,id',
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:categories,id',
        ]);

        $monster = Monster::create(collect($validated)->except([
            'categories',
            'locations',
        ])->toArray());

        $monster->locations()->sync(collect($validated['locations'])->pluck('id'));
        $monster->categories()->sync(collect($validated['categories'])->pluck('id'));

        return to_route('monsters.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Monster $monster): Response
    {
        return Inertia::render('monsters/Show', [
            'monster' => $monster->load(
                'image',
                'image.media',
                'element',
                'element.image.media',
                'race',
                'race.image.media',
                'locations',
                'categories',
                'locations.categories'
            ),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Monster $monster): Response
    {
        $images = Image::with('media')->get();
        $races = Race::with('image', 'image.media')->get();
        $elements = Element::with('image', 'image.media')->get();
        $defenceTypes = MonsterDefenceEnum::values();
        $combatModes = MonsterModeEnum::values();
        $categories = Category::select(['id', 'name'])->get();
        $locations = Location::select(['id', 'name'])->get();

        return Inertia::render('monsters/Edit', [
            'monster' => $monster->load([
                'image',
                'image.media',
                'element',
                'element.image',
                'element.image.media',
                'race',
                'race.image',
                'race.image.media',
                'locations',
                'categories',
            ]),
            'images' => $images,
            'races' => $races,
            'elements' => $elements,
            'defence_types' => $defenceTypes,
            'combat_modes' => $combatModes,
            'categories' => $categories,
            'locations' => $locations,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Monster $monster)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('monsters', 'name')->ignore($monster->id),
            ],
            'level' => 'required|min:1|max:70',
            'health_points' => 'required|numeric|min:1',
            'element_id' => 'required|exists:elements,id',
            'element_strength' => 'required|numeric|min:1',
            'race_id' => 'required|exists:races,id',
            'is_aggressive' => 'required|boolean',
            'is_elite' => 'required|boolean',
            'is_boss' => 'required|boolean',
            'pick_up_loot' => 'required|boolean',
            'shield' => 'nullable|numeric|min:0',
            'experience' => 'required|numeric|min:0',
            'xp_per_hp' => 'required|numeric|min:0',
            'defence' => [
                'required',
                Rule::enum(MonsterDefenceEnum::class),
            ],
            'combat_mode' => [
                'required',
                Rule::enum(MonsterModeEnum::class),
            ],
            'quest_only' => 'required|boolean',
            'image_id' => 'required|exists:images,id',
            'locations' => 'required|array',
            'locations.*.id' => 'required|exists:locations,id',
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:categories,id',
        ]);

        $monster->update(collect($validated)->except([
            'categories',
            'locations',
        ])->toArray());

        $monster->locations()->sync(collect($validated['locations'])->pluck('id'));
        $monster->categories()->sync(collect($validated['categories'])->pluck('id'));

        return to_route('monsters.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Monster $monster)
    {
        $monster->delete();

        return to_route('monsters.index');
    }
}

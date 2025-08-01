<?php

namespace App\Http\Controllers\Npc;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Models\Location;
use App\Models\Npc;
use App\Models\NpcGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class NpcController extends Controller
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

        $query = Npc::with(['image', 'image.media', 'locations', 'npc_groups']);

        $query->leftJoin('location_npcs', 'npcs.id', '=', 'location_npcs.npc_id')
            ->leftJoin('locations', 'locations.id', '=', 'location_npcs.location_id')
            ->select('npcs.*')
            ->addSelect(DB::raw("(
                SELECT string_agg(l2.name, ', ' ORDER BY l2.name ASC)
                FROM locations l2
                JOIN location_npcs ln2 ON ln2.location_id = l2.id
                WHERE ln2.npc_id = npcs.id
            ) as location_names"));

        if ($request->filled('name')) {
            $query->whereLike('npcs.name', '%' . $name . '%', boolean: 'or');
        }

        if ($sortField == 'name') {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->orderBy('location_names', $sortDirection);
        }

        $query->groupBy('npcs.id', 'npcs.name');

        $npcs = $query->paginate($perPage)
            ->withQueryString();

        $npcGroups = NpcGroup::all();

        return Inertia::render('npcs/Index', [
            'npcs' => $npcs->items(),
            'npc_groups' => $npcGroups,
            'pagination' => [
                'total' => $npcs->total(),
                'per_page' => $npcs->perPage(),
                'current_page' => $npcs->currentPage(),
                'last_page' => $npcs->lastPage(),
            ],
            'filters' => [
                ['name' => $name]
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $npcGroups = NpcGroup::select(['id', 'name'])->orderBy('name')->get();
        $locations = Location::select(['id', 'name'])->orderBy('name')->get();
        $images = Image::with('media')->get();
        $categories = Category::select(['id', 'name'])->orderBy('name')->get();

        return Inertia::render('npcs/Create', [
            'npc_groups' => $npcGroups,
            'locations' => $locations,
            'categories' => $categories,
            'images' => $images,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|unique:npcs|max:255',
            'image_id' => 'required|exists:images,id',
            'npc_groups' => 'required|array',
            'npc_groups.*.id' => 'exists:npc_groups,id',
            'locations' => 'required|array',
            'locations.*.id' => 'exists:locations,id',
            'categories' => 'required|array',
            'categories.*.id' => 'exists:categories,id',
        ]);

        $npc = Npc::create(collect($validated)->except([
            'npc_groups',
            'locations',
            'categories',
        ])->toArray());

        $npc->npc_groups()->sync(collect($validated['npc_groups'])->pluck('id'));
        $npc->locations()->sync(collect($validated['locations'])->pluck('id'));
        $npc->categories()->sync(collect($validated['categories'])->pluck('id'));

        return to_route('npcs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Npc $npc): Response
    {
        return Inertia::render('npcs/Show', [
            'npc' => $npc->load([
                'image',
                'image.media',
                'locations',
                'categories',
                'npc_groups',
            ]),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Npc $npc): Response
    {
        $npcGroups = NpcGroup::select(['id', 'name'])->orderBy('name')->get();
        $locations = Location::select(['id', 'name'])->orderBy('name')->get();
        $images = Image::with('media')->get();
        $categories = Category::select(['id', 'name'])->orderBy('name')->get();

        return Inertia::render('npcs/Edit', [
            'npc' => $npc->load(['image', 'image.media', 'locations', 'categories', 'npc_groups']),
            'npc_groups' => $npcGroups,
            'locations' => $locations,
            'categories' => $categories,
            'images' => $images,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Npc $npc)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('npcs', 'name')->ignore($npc->id),
            ],
            'image_id' => 'required|exists:images,id',
            'npc_groups' => 'required|array',
            'npc_groups.*.id' => 'exists:npc_groups,id',
            'locations' => 'required|array',
            'locations.*.id' => 'exists:locations,id',
            'categories' => 'required|array',
            'categories.*.id' => 'exists:categories,id',
        ]);

        $npc->update(collect($validated)->except([
            'npc_groups',
            'locations',
            'categories',
        ])->toArray());

        $npc->npc_groups()->sync(collect($validated['npc_groups'])->pluck('id'));
        $npc->locations()->sync(collect($validated['locations'])->pluck('id'));
        $npc->categories()->sync(collect($validated['categories'])->pluck('id'));

        return to_route('npcs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Npc $npc)
    {
        $npc->delete();

        return to_route('npcs.index');
    }
}

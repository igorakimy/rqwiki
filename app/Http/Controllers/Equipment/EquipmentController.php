<?php

namespace App\Http\Controllers\Equipment;

use App\Enums\BonusesValueTypeEnum;
use App\Enums\EquipmentItemClassEnum;
use App\Enums\EquipmentTypeEnum;
use App\Enums\GenderEnum;
use App\Http\Controllers\Controller;
use App\Models\Bonus;
use App\Models\Category;
use App\Models\CharacterClass;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Image;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class EquipmentController extends Controller
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
        $equipmentType = $request->input('equipment_type');

        $query = Equipment::with([
            'equipment_type',
            'image',
            'image.media',
            'classes',
            'classes.image.media',
            'bonuses'
        ]);

        $query->leftJoin('class_equipment', 'equipment.id', '=', 'class_equipment.equipment_id')
            ->leftJoin('classes', 'classes.id', '=', 'class_equipment.class_id')
            ->select('equipment.*')
            ->addSelect(DB::raw("(
                SELECT string_agg(c2.name, ', ' ORDER BY c2.name ASC)
                FROM classes c2
                JOIN class_equipment ce2 ON ce2.class_id = c2.id
                WHERE ce2.equipment_id = equipment.id
            ) as character_classes"));

        if ($request->filled('name')) {
            $query->whereLike('equipment.name', '%' . $name . '%', boolean: 'or');
        }

        if ($request->filled('equipment_type')) {
            $query = $query->whereRelation('equipment_type', 'equipment_types.id', '=', $equipmentType);
        }

        if (in_array($sortField, ['name', 'gender', 'required_level', 'defence', 'selling_price'])) {
            $query->orderBy("equipment.$sortField", $sortDirection);
        }

        if ($sortField == 'classes') {
            $query->orderBy("character_classes", $sortDirection);
        }

        $query->groupBy('equipment.id', 'equipment.name');

        $equipment = $query->paginate($perPage)->withQueryString();

        return Inertia::render('equipment/Index', [
            'equipment' => $equipment->items(),
            'pagination' => [
                'total' => $equipment->total(),
                'per_page' => $equipment->perPage(),
                'current_page' => $equipment->currentPage(),
                'last_page' => $equipment->lastPage(),
            ],
            'filters' => [
                [
                    'column' => 'name',
                    'label' => 'Название',
                    'value' => $name,
                ],
                [
                    'column' => 'equipment_type',
                    'label' => 'Тип экипировки',
                    'value' => 0,
                    'options' => EquipmentType::where('type', EquipmentTypeEnum::EQUIPMENT)
                        ->get(['id', 'name']),
                ],
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $images = Image::with(['media'])->get();
        $categories = Category::select(['id', 'name'])->get();
        $genders = GenderEnum::values();
        $itemClasses = EquipmentItemClassEnum::values();
        $equipmentTypes = EquipmentType::select(['id', 'name'])->where('type', 'экипировка')->get();
        $characterClasses = CharacterClass::select(['id', 'name'])->get();
        $bonuses = Bonus::select(['id', 'name'])->orderBy('name')->get();

        return Inertia::render('equipment/Create', [
            'images' => $images,
            'categories' => $categories,
            'genders' => $genders,
            'item_classes' => $itemClasses,
            'equipment_types' => $equipmentTypes,
            'character_classes' => $characterClasses,
            'bonuses' => $bonuses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image_id' => 'required|exists:images,id',
            'item_class' => [
                'required',
                Rule::enum(EquipmentItemClassEnum::class),
            ],
            'required_level' => 'required|integer|between:1,70',
            'max_slots_amount' => 'required|integer|min:0|max:3',
            'defence' => 'integer|min:0',
            'gender' => [
                'required',
                Rule::enum(GenderEnum::class),
            ],
            'equipment_type_id' => 'required|exists:equipment_types,id',
            'selling_price' => 'integer|min:0',
            'character_classes' => 'array',
            'character_classes.*' => 'exists:classes,id',
            'bonuses' => 'required|array',
            'bonuses.*.bonus_id' => 'exists:bonuses,id',
            'bonuses.*.value' => 'numeric|min:1',
            'bonuses.*.value_type' => [
                Rule::enum(BonusesValueTypeEnum::class)
            ],
            'bonuses.*.duration' => 'numeric',
            'bonuses.*.use_alt_name' => 'boolean',
            'bonuses.*.special_property' => 'nullable|string',
            'categories' => 'required|array|min:1',
            'categories.*.id' => 'exists:categories,id',
        ]);

        $equipment = Equipment::create(collect($validated)->except([
            'character_classes',
            'bonuses',
            'categories',
        ])->toArray());

        $equipment->classes()->sync($validated['character_classes']);

        $bonuses = [];
        foreach ($validated['bonuses'] as $idx => $bonus) {
            $bonuses[$bonus['bonus_id']] = collect($bonus)->except([
                'id', 'bonus_id'
            ])->put('order', $idx + 1)->toArray();
        }

        $equipment->bonuses()->sync($bonuses);

        $equipment->categories()->sync(collect($validated['categories'])->pluck('id'));


        return to_route('equipment.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment): Response
    {
        $equipment = $equipment->load([
            'equipment_type',
            'classes',
            'classes.image.media',
            'image.media',
            'bonuses',
            'categories',
        ]);

        return Inertia::render('equipment/Show', [
            'equipment' => $equipment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment): Response
    {
        $images = Image::with(['media'])->get();
        $categories = Category::select(['id', 'name'])->get();
        $genders = GenderEnum::values();
        $itemClasses = EquipmentItemClassEnum::values();
        $characterClasses = CharacterClass::select(['id', 'name'])->get();
        $equipmentTypes = EquipmentType::select(['id', 'name'])->where('type', 'экипировка')->get();
        $bonuses = Bonus::select(['id', 'name'])->orderBy('name')->get();
        $equipment = $equipment->load([
            'equipment_type',
            'classes',
            'image.media',
            'bonuses',
            'categories',
        ]);

        return Inertia::render('equipment/Edit', [
            'equipment' => $equipment,
            'images' => $images,
            'categories' => $categories,
            'genders' => $genders,
            'item_classes' => $itemClasses,
            'equipment_types' => $equipmentTypes,
            'character_classes' => $characterClasses,
            'bonuses' => $bonuses,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('equipment', 'name')->ignore($equipment->id),
            ],
            'image_id' => 'required|exists:images,id',
            'item_class' => [
                'required',
                Rule::enum(EquipmentItemClassEnum::class),
            ],
            'required_level' => 'required|integer|between:1,70',
            'max_slots_amount' => 'required|integer|min:0|max:3',
            'defence' => 'integer|min:0',
            'gender' => [
                'required',
                Rule::enum(GenderEnum::class),
            ],
            'equipment_type_id' => 'required|exists:equipment_types,id',
            'selling_price' => 'integer|min:0',
            'character_classes' => 'array',
            'character_classes.*' => 'exists:classes,id',
            'bonuses' => 'required|array',
            'bonuses.*.bonus_id' => 'exists:bonuses,id',
            'bonuses.*.value' => 'numeric|min:1',
            'bonuses.*.value_type' => [
                Rule::enum(BonusesValueTypeEnum::class)
            ],
            'bonuses.*.duration' => 'numeric',
            'bonuses.*.use_alt_name' => 'boolean',
            'bonuses.*.special_property' => 'nullable|string',
            'categories' => 'required|array|min:1',
            'categories.*.id' => 'exists:categories,id',
        ]);

        $equipment->update(collect($validated)->except([
            'character_classes',
            'bonuses',
            'categories',
        ])->toArray());

        $equipment->classes()->sync($validated['character_classes']);

        $bonuses = [];
        foreach ($validated['bonuses'] as $idx => $bonus) {
            $bonuses[$bonus['bonus_id']] = collect($bonus)->except([
                'id', 'bonus_id'
            ])->put('order', $idx + 1)->toArray();
        }

        $equipment->bonuses()->sync($bonuses);

        $equipment->categories()->sync(collect($validated['categories'])->pluck('id'));

        return to_route('equipment.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment): RedirectResponse
    {
        $equipment->delete();

        return to_route('equipment.index');
    }
}

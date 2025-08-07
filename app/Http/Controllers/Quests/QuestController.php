<?php

namespace App\Http\Controllers\Quests;

use App\Http\Controllers\Controller;
use App\Models\Npc;
use App\Models\Quest;
use App\Models\QuestChain;
use App\Models\QuestType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class QuestController extends Controller
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

        $query = Quest::with([]);

        if ($request->filled('name')) {
            $query->whereLike('name', '%' . $name . '%', boolean: 'or');
        }

        if (in_array($sortField, ['name', 'required_level', 'gold', 'experience'])) {
            $query->orderBy($sortField, $sortDirection);
        }

        $quests = $query->paginate($perPage)
            ->withQueryString();

        $questChains = QuestChain::all()->chunk(8)->all();

        return Inertia::render('quests/Index', [
            'quests' => $quests->items(),
            'quest_chains' => $questChains,
            'pagination' => [
                'total' => $quests->total(),
                'per_page' => $quests->perPage(),
                'current_page' => $quests->currentPage(),
                'last_page' => $quests->lastPage(),
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
        $npcs = Npc::all();
        $questTypes = QuestType::select(['id', 'name'])->get();
        $questChains = QuestChain::select(['id', 'name'])->get();
        $previousQuests = Quest::select(['id', 'name'])->get();

        return Inertia::render('quests/Create', [
            'npcs' => $npcs,
            'quest_types' => $questTypes,
            'quest_chains' => $questChains,
            'prev_quests' => $previousQuests,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255|unique:quests,name',
            'required_level' => 'required|numeric|min:1|max:70',
            'gold' => 'required|numeric|min:0',
            'experience' => 'required|numeric|min:0',
            'condition' => 'nullable|string|max:5000',
            'condition_description' => 'nullable|string|max:5000',
            'explanation' => 'nullable|string|max:5000',
            'quest_chain_id' => 'nullable|exists:quest_chains,id',
            'quest_type_id' => 'required|exists:quest_types,id',
            'npc_from' => 'nullable',
            'npc_from.id' => 'exists:npcs,id',
            'npc_to' => 'nullable',
            'npc_to.id' => 'exists:npcs,id',
            'prev_quests' => 'nullable|array',
            'prev_quests.*.id' => 'exists:quests,id',
        ]);

        $data = collect($validated)->except([
            'npc_from',
            'npc_to',
            'prev_quests',
        ])->toArray();

        if (!empty($validated['npc_from'])) {
            $data['npc_from_id'] = $validated['npc_from']['id'];
        } else {
            $data['npc_from_id'] = null;
        }

        if (!empty($validated['npc_to'])) {
            $data['npc_to_id'] = $validated['npc_to']['id'];
        } else {
            $data['npc_to_id'] = null;
        }

        $quest = Quest::create($data);

        $quest->prev_quests()->sync(collect($validated['prev_quests'])->pluck('id'));

        return to_route('quests.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quest $quest): Response
    {
        $quest = $quest->load([
            'npc_from',
            'npc_from.image.media',
            'npc_to',
            'npc_to.image.media',
            'quest_chain',
            'quest_type',
            'prev_quests',
            'next_quests',
        ]);

        return Inertia::render('quests/Show', [
            'quest' => $quest,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quest $quest): Response
    {
        $npcs = Npc::all();
        $questTypes = QuestType::select(['id', 'name'])->get();
        $questChains = QuestChain::select(['id', 'name'])->get();
        $previousQuests = Quest::select(['id', 'name'])->get();

        $quest = $quest->load([
            'npc_from',
            'npc_from.image.media',
            'npc_to',
            'npc_to.image.media',
            'quest_chain',
            'quest_type',
            'prev_quests',
            'next_quests',
        ]);

        return Inertia::render('quests/Edit', [
            'quest' => $quest,
            'npcs' => $npcs,
            'quest_types' => $questTypes,
            'quest_chains' => $questChains,
            'prev_quests' => $previousQuests,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quest $quest)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('quests', 'name')->ignore($quest->id),
            ],
            'required_level' => 'required|numeric|min:1|max:70',
            'gold' => 'required|numeric|min:0',
            'experience' => 'required|numeric|min:0',
            'condition' => 'nullable|string|max:5000',
            'condition_description' => 'nullable|string|max:5000',
            'explanation' => 'nullable|string|max:5000',
            'quest_chain_id' => 'nullable|exists:quest_chains,id',
            'quest_type_id' => 'required|exists:quest_types,id',
            'npc_from' => 'nullable',
            'npc_from.id' => 'exists:npcs,id',
            'npc_to' => 'nullable',
            'npc_to.id' => 'exists:npcs,id',
            'prev_quests' => 'nullable|array',
            'prev_quests.*.id' => 'exists:quests,id',
        ]);

        $data = collect($validated)->except([
            'npc_from',
            'npc_to',
            'prev_quests',
        ])->toArray();

        if (!empty($validated['npc_from'])) {
            $data['npc_from_id'] = $validated['npc_from']['id'];
        } else {
            $data['npc_from_id'] = null;
        }

        if (!empty($validated['npc_to'])) {
            $data['npc_to_id'] = $validated['npc_to']['id'];
        } else {
            $data['npc_to_id'] = null;
        }

        $quest->update($data);

        $quest->prev_quests()->sync(collect($validated['prev_quests'])->pluck('id'));

        return to_route('quests.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quest $quest): RedirectResponse
    {
        $quest->delete();

        return to_route('quests.index');
    }
}

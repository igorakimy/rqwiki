<?php

namespace App\Http\Controllers\WorldMap;

use App\Http\Controllers\Controller;
use App\Models\WorldMap;
use Inertia\Inertia;
use Inertia\Response;

class WorldMapController extends Controller
{
    public function index(): Response
    {
        $worldMap = WorldMap::with(['image', 'image.media', 'locations'])->first();

        return Inertia::render('world_map/Index', [
            'world_map' => $worldMap
        ]);
    }
}

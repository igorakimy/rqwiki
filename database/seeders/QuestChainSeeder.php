<?php

namespace Database\Seeders;

use App\Models\QuestChain;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class QuestChainSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     * @throws FileNotFoundException
     */
    public function run(): void
    {
        $questChainsFile = resource_path('data/quest_chains.json');

        $questChains = File::json($questChainsFile);

        foreach ($questChains as $questChain) {
            QuestChain::create([
                'name' => $questChain['name'],
            ]);
        }
    }
}

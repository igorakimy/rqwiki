<?php

namespace App\Models;

use App\Traits\HasCategories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Quest extends Model
{
    use HasCategories, HasFactory;

    protected $guarded = [];

    /**
     * Тип задания (обычное, ежедневное, повторяемое).
     *
     * @return BelongsTo
     */
    public function quest_type(): BelongsTo
    {
        return $this->belongsTo(QuestType::class);
    }

    /**
     * Квестовая цепочка.
     *
     * @return BelongsTo
     */
    public function quest_chain(): BelongsTo
    {
        return $this->belongsTo(QuestChain::class);
    }

    /**
     * НПС, который выдаёт задание.
     *
     * @return BelongsTo
     */
    public function npc_from(): BelongsTo
    {
        return $this->belongsTo(Npc::class, 'npc_from_id');
    }

    /**
     * НПС, который принимает задание.
     *
     * @return BelongsTo
     */
    public function npc_to(): BelongsTo
    {
        return $this->belongsTo(Npc::class, 'npc_to_id');
    }

    /**
     * Предыдущие квесты в цепочке.
     *
     * @return BelongsToMany
     */
    public function prev_quests(): BelongsToMany
    {
        return $this->belongsToMany(
            Quest::class,
            'quest_prerequisite',
            'quest_id',
            'prev_quest_id',
        );
    }

    /**
     * Следующие квесты в цепочке.
     *
     * @return BelongsToMany
     */
    public function next_quests(): BelongsToMany
    {
        return $this->belongsToMany(
            Quest::class,
            'quest_prerequisite',
            'prev_quest_id',
            'quest_id',
        );
    }
}

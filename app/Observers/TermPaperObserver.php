<?php

namespace App\Observers;

use App\Models\TermPaper;
use App\Models\TermPaperStatusHistory;

class TermPaperObserver
{
    /**
     * Handle the TermPaper "created" event.
     */
    public function created(TermPaper $termPaper): void
    {
        TermPaperStatusHistory::create([
            'term_paper_id' => $termPaper->id,
            'label' => 'Дипломна Работа Създадена',
            'status' => $termPaper->status->value,
            'happened_at' => $termPaper->created_at,
        ]);
    }

    /**
     * Handle the TermPaper "updated" event.
     */
    public function updated(TermPaper $termPaper): void
    {
        if ($termPaper->isDirty('status')) {
            TermPaperStatusHistory::create([
                'term_paper_id' => $termPaper->id,
                'label' => 'Дипломна Работа Актуализирана',
                'status' => $termPaper->status->value,
                'happened_at' => now(),
            ]);
        }
    }

    /**
     * Handle the TermPaper "deleted" event.
     */
    public function deleted(TermPaper $termPaper): void
    {
        TermPaperStatusHistory::create([
            'term_paper_id' => $termPaper->id,
            'label' => 'Дипломна Работа Изтрита',
            'status' => $termPaper->status->value,
            'happened_at' => now(),
        ]);
    }

    /**
     * Handle the TermPaper "restored" event.
     */
    public function restored(TermPaper $termPaper): void
    {
        TermPaperStatusHistory::create([
            'term_paper_id' => $termPaper->id,
            'label' => 'Дипломна Работа Възстановена',
            'status' => $termPaper->status->value,
            'happened_at' => now(),
        ]);
    }

    /**
     * Handle the TermPaper "force deleted" event.
     */
    public function forceDeleted(TermPaper $termPaper): void
    {

        TermPaperStatusHistory::create([
            'term_paper_id' => $termPaper->id,
            'label' => 'Дипломна Работа Перманентно Изтрита',
            'status' => $termPaper->status->value,
            'happened_at' => now(),
        ]);

    }
}

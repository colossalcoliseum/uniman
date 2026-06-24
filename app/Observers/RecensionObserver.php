<?php

namespace App\Observers;

use App\Models\Recension;
use App\Models\TermPaperStatusHistory;

class RecensionObserver
{
    /**
     * Handle the Recension "created" event.
     */
    public function created(Recension $recension): void
    {
        TermPaperStatusHistory::create([
            'term_paper_id' => $recension->term_paper_id,
            'label' => 'Рецензирана',
            'status' => null,
            'happened_at' => $recension->created_at,
        ]);
    }

    /**
     * Handle the Recension "updated" event.
     */
    public function updated(Recension $recension): void
    {
        //
    }

    /**
     * Handle the Recension "deleted" event.
     */
    public function deleted(Recension $recension): void
    {
        //
    }

    /**
     * Handle the Recension "restored" event.
     */
    public function restored(Recension $recension): void
    {
        //
    }

    /**
     * Handle the Recension "force deleted" event.
     */
    public function forceDeleted(Recension $recension): void
    {
        //
    }
}

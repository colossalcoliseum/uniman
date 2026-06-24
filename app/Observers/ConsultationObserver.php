<?php

namespace App\Observers;

use App\Enums\TermPaperStatus;
use App\Models\Consultation;
use App\Models\TermPaperStatusHistory;

class ConsultationObserver
{
    /**
     * Handle the Consultation "created" event.
     */
    public function created(Consultation $consultation): void
    {
        if ($consultation->term_paper_id === null) {
            return;
        }

        $isFirst = \App\Models\Consultation::where('term_paper_id', $consultation->term_paper_id)->count() === 1;

        TermPaperStatusHistory::create([
            'term_paper_id' => $consultation->term_paper_id,
            'label' => $isFirst ? 'Първа консултация' : 'Консултация проведена',
            'status' => null,
            'happened_at' => $consultation->starts_at,
        ]);
    }
    /**
     * Handle the Consultation "updated" event.
     */
    public function updated(Consultation $consultation): void
    {

    }

    /**
     * Handle the Consultation "deleted" event.
     */
    public function deleted(Consultation $consultation): void
    {
        //
    }

    /**
     * Handle the Consultation "restored" event.
     */
    public function restored(Consultation $consultation): void
    {
        //
    }

    /**
     * Handle the Consultation "force deleted" event.
     */
    public function forceDeleted(Consultation $consultation): void
    {
        //
    }


}

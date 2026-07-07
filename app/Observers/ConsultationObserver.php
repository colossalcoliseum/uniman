<?php

namespace App\Observers;

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
        TermPaperStatusHistory::create([
            'term_paper_id' => $consultation->term_paper_id,
            'label' => 'Консултация Записана',
            'status' => null,
            'happened_at' => $consultation->starts_at,
        ]);
    }

    /**
     * Handle the Consultation "updated" event.
     */
    public function updated(Consultation $consultation): void {
        if ($consultation->term_paper_id === null) {
            return;
        }
        TermPaperStatusHistory::create([
            'term_paper_id' => $consultation->term_paper_id,
            'label' => 'Информация за Консултацията Актуализирана',
            'status' => null,
            'happened_at' => $consultation->starts_at,
        ]);
    }

    /**
     * Handle the Consultation "deleted" event.
     */
    public function deleted(Consultation $consultation): void
    {
        if ($consultation->term_paper_id === null) {
            return;
        }
        TermPaperStatusHistory::create([
            'term_paper_id' => $consultation->term_paper_id,
            'label' => 'Консултация Изтрита',
            'status' => null,
            'happened_at' => $consultation->starts_at,
        ]);
    }

    /**
     * Handle the Consultation "restored" event.
     */
    public function restored(Consultation $consultation): void
    {
        if ($consultation->term_paper_id === null) {
            return;
        }
        TermPaperStatusHistory::create([
            'term_paper_id' => $consultation->term_paper_id,
            'label' => 'Консултация Възстановена',
            'status' => null,
            'happened_at' => $consultation->starts_at,
        ]);
    }

    /**
     * Handle the Consultation "force deleted" event.
     */
    public function forceDeleted(Consultation $consultation): void
    {
        if ($consultation->term_paper_id === null) {
            return;
        }
        TermPaperStatusHistory::create([
            'term_paper_id' => $consultation->term_paper_id,
            'label' => 'Консултация Перманентно Изтрита',
            'status' => null,
            'happened_at' => $consultation->starts_at,
        ]);
    }
}

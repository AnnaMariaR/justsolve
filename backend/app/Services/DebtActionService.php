<?php

namespace App\Services;

use App\Models\Debt;

class DebtActionService
{
    public function suggest(Debt $debt): array
    {
        if ($debt->days_overdue >= 60 && $debt->amount >= 1000) {
            return [
                'action' => 'ESCALATE_LEGAL',
                'reason' => 'Debt is significantly overdue and above 1000 EUR.',
            ];
        }

        if ($debt->days_overdue >= 30) {
            return [
                'action' => 'OFFER_PAYMENT_PLAN',
                'reason' => 'Debt has been overdue for more than 30 days.',
            ];
        }

        return [
            'action' => 'SEND_REMINDER',
            'reason' => 'Debt is overdue but still recent.',
        ];
    }
}

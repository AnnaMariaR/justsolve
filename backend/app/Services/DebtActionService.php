<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Debt;

/**
 * Service for suggesting debt collection actions based on business rules.
 */
class DebtActionService
{
    /**
     * Suggest the next action to take for a debt based on amount and days overdue.
     *
     * Business rules:
     * - If days_overdue >= 60 AND amount >= 1000 EUR → ESCALATE_LEGAL
     * - Else if days_overdue >= 30 → OFFER_PAYMENT_PLAN
     * - Else → SEND_REMINDER
     *
     * @param Debt $debt
     * @return array{action: string, reason: string}
     */
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

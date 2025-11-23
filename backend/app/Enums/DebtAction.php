<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Enum for debt collection actions.
 */
enum DebtAction: string
{
    case SEND_REMINDER = 'SEND_REMINDER';
    case OFFER_PAYMENT_PLAN = 'OFFER_PAYMENT_PLAN';
    case ESCALATE_LEGAL = 'ESCALATE_LEGAL';

    /**
     * Get all action values as an array.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get a comma-separated string of all action values.
     *
     * @return string
     */
    public static function valuesString(): string
    {
        return implode(',', self::values());
    }

    /**
     * Get all actions with their labels for display.
     *
     * @return array<array{value: string, label: string}>
     */
    public static function toArray(): array
    {
        return array_map(
            fn(self $action) => [
                'value' => $action->value,
                'label' => $action->label(),
            ],
            self::cases()
        );
    }

    /**
     * Get a human-readable label for this action.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::SEND_REMINDER => 'Send Reminder',
            self::OFFER_PAYMENT_PLAN => 'Offer Payment Plan',
            self::ESCALATE_LEGAL => 'Escalate to Legal',
        };
    }
}
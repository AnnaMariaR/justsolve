<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Debt;
use App\Services\DebtActionService;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for DebtActionService.
 */
class DebtActionServiceTest extends TestCase
{
    private DebtActionService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DebtActionService();
    }

    /**
     * Test that ESCALATE_LEGAL is suggested when days_overdue >= 60 AND amount >= 1000.
     */
    public function testSuggestsEscalateLegalForHighAmountAndLongOverdue(): void
    {
        $debt = new Debt([
            'debtor_name' => 'John Doe',
            'amount' => 1500.00,
            'days_overdue' => 75,
            'status' => 'OPEN',
        ]);

        $result = $this->service->suggest($debt);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('action', $result);
        $this->assertArrayHasKey('reason', $result);
        $this->assertEquals('ESCALATE_LEGAL', $result['action']);
        $this->assertStringContainsString('1000 EUR', $result['reason']);
    }

    /**
     * Test that ESCALATE_LEGAL is suggested at the boundary (exactly 60 days and 1000 EUR).
     */
    public function testSuggestsEscalateLegalAtBoundary(): void
    {
        $debt = new Debt([
            'debtor_name' => 'Jane Smith',
            'amount' => 1000.00,
            'days_overdue' => 60,
            'status' => 'OPEN',
        ]);

        $result = $this->service->suggest($debt);

        $this->assertEquals('ESCALATE_LEGAL', $result['action']);
    }

    /**
     * Test that OFFER_PAYMENT_PLAN is suggested when days_overdue >= 30 but conditions for ESCALATE_LEGAL not met.
     */
    public function testSuggestsOfferPaymentPlanFor30DaysOverdue(): void
    {
        $debt = new Debt([
            'debtor_name' => 'Bob Johnson',
            'amount' => 500.00,
            'days_overdue' => 45,
            'status' => 'OPEN',
        ]);

        $result = $this->service->suggest($debt);

        $this->assertEquals('OFFER_PAYMENT_PLAN', $result['action']);
        $this->assertStringContainsString('30 days', $result['reason']);
    }

    /**
     * Test that OFFER_PAYMENT_PLAN is suggested when days >= 60 but amount < 1000.
     */
    public function testSuggestsOfferPaymentPlanWhenHighDaysButLowAmount(): void
    {
        $debt = new Debt([
            'debtor_name' => 'Charlie Wilson',
            'amount' => 999.99,
            'days_overdue' => 65,
            'status' => 'OPEN',
        ]);

        $result = $this->service->suggest($debt);

        $this->assertEquals('OFFER_PAYMENT_PLAN', $result['action']);
    }

    /**
     * Test that SEND_REMINDER is suggested for recent debts (less than 30 days).
     */
    public function testSuggestsSendReminderForRecentDebt(): void
    {
        $debt = new Debt([
            'debtor_name' => 'David Miller',
            'amount' => 300.00,
            'days_overdue' => 15,
            'status' => 'OPEN',
        ]);

        $result = $this->service->suggest($debt);

        $this->assertEquals('SEND_REMINDER', $result['action']);
        $this->assertStringContainsString('recent', $result['reason']);
    }
}

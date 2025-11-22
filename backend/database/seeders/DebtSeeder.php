<?php

namespace Database\Seeders;

use App\Models\Debt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DebtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $debts = [
            [
                'external_id' => 'DEBT-001',
                'debtor_name' => 'John Smith',
                'amount' => 1500.00,
                'days_overdue' => 75,
                'status' => 'OPEN',
            ],
            [
                'external_id' => 'DEBT-002',
                'debtor_name' => 'Sarah Johnson',
                'amount' => 850.50,
                'days_overdue' => 45,
                'status' => 'OPEN',
            ],
            [
                'external_id' => 'DEBT-003',
                'debtor_name' => 'Michael Brown',
                'amount' => 2500.00,
                'days_overdue' => 90,
                'status' => 'OPEN',
            ],
            [
                'external_id' => 'DEBT-004',
                'debtor_name' => 'Emily Davis',
                'amount' => 450.00,
                'days_overdue' => 15,
                'status' => 'OPEN',
            ],
            [
                'external_id' => 'DEBT-005',
                'debtor_name' => 'David Wilson',
                'amount' => 1200.00,
                'days_overdue' => 60,
                'status' => 'OPEN',
            ],
            [
                'external_id' => 'DEBT-006',
                'debtor_name' => 'Lisa Anderson',
                'amount' => 750.00,
                'days_overdue' => 35,
                'status' => 'OPEN',
            ],
            [
                'external_id' => 'DEBT-007',
                'debtor_name' => 'Robert Taylor',
                'amount' => 3000.00,
                'days_overdue' => 120,
                'status' => 'RESOLVED',
            ],
        ];

        foreach ($debts as $debt) {
            Debt::create($debt);
        }
    }
}

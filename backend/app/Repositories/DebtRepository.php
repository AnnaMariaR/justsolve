<?php

namespace App\Repositories;

use App\Models\Debt;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Repository for handling Debt model database operations.
 */
class DebtRepository
{
    /**
     * Get all open debts.
     *
     * @return Collection
     */
    public function getAllOpen(): Collection
    {
        return Debt::where('status', 'OPEN')->get();
    }

    /**
     * Find a debt by ID.
     *
     * @param int $id The debt ID
     * @return Debt
     * @throws ModelNotFoundException
     */
    public function findById(int $id): Debt
    {
        return Debt::findOrFail($id);
    }

    /**
     * Update a debt's last action.
     *
     * @param Debt $debt The debt to update
     * @param string $action The action name
     * @return Debt The updated debt
     */
    public function updateLastAction(Debt $debt, string $action): Debt
    {
        $debt->last_action = $action;
        $debt->last_action_at = now();
        $debt->save();

        return $debt;
    }
}

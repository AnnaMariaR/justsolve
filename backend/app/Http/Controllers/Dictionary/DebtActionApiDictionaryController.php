<?php

namespace App\Http\Controllers\Dictionary;

use App\Enums\DebtAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * Handles dictionary/lookup data for debt actions.
 */
class DebtActionApiDictionaryController extends Controller
{
    /**
     * Get all available debt actions with their labels.
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return response()->json(DebtAction::toArray());
    }
}
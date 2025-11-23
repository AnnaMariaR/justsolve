<?php

namespace App\Http\Controllers;

use App\Http\Requests\DebtActionApiRequest;
use App\Models\Debt;
use App\Repositories\DebtRepository;
use App\Services\DebtActionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handles debt management operations including listing, viewing, and applying actions.
 */
class DebtApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param DebtRepository $debtRepository
     * @param DebtActionService $debtActionService
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly DebtRepository $debtRepository,
        private readonly DebtActionService $debtActionService,
        private readonly LoggerInterface $logger,
    ) {}

    /**
     * Get all open debts.
     *
     * @return JsonResponse
     */
    public function listAll(): JsonResponse
    {
        try {
            $debts = $this->debtRepository->getAllOpen();
            return response()->json($debts);
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);

            return response()->json([
                'message' => 'Failed to retrieve debts',
                'error' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get a specific debt by ID.
     *
     * @param Debt $debt
     * @return JsonResponse
     */
    public function view(Debt $debt): JsonResponse
    {
        try {
            return response()->json($debt);
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);

            return response()->json([
                'message' => 'Failed to retrieve debt',
                'error' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get a suggested action for a debt based on amount and days overdue.
     *
     * @param Debt $debt
     * @return JsonResponse
     */
    public function showSuggestion(Debt $debt): JsonResponse
    {
        try {
            $suggestion = $this->debtActionService->suggest($debt);
            return response()->json($suggestion);
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);

            return response()->json([
                'message' => 'Failed to generate suggestion',
                'error' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Apply an action to a debt.
     *
     * @param DebtActionApiRequest $request
     * @param Debt $debt
     * @return JsonResponse
     */
    public function applyAction(DebtActionApiRequest $request, Debt $debt): JsonResponse
    {
        try {
            $validated = $request->validated();

            if ($debt->status !== 'OPEN') {
                return response()->json([
                    'message' => 'Actions can only be applied to open debts',
                ], Response::HTTP_BAD_REQUEST);
            }

            $debt = $this->debtRepository->updateLastAction($debt, $validated['action']);

            return response()->json([
                'message' => 'Action applied successfully',
                'debt' => $debt,
            ]);
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);

            return response()->json([
                'message' => 'Failed to apply action',
                'error' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

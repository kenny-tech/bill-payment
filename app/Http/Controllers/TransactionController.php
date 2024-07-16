<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Repositories\TransactionRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponse;

class TransactionController extends Controller
{
    use ApiResponse;

    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepo)
    {
        $this->transactionRepository = $transactionRepo;
    }

    public function createTransaction(Request $request)
    {
        try {
            $request->validate([
                'amount' => 'required|numeric',
                'type' => 'required|string',
                'description' => 'nullable|string',
            ]);

            $user = Auth::user();
            $data = $request->all();
            $data['user_id'] = $user->id;
    
            $transaction = $this->transactionRepository->create($data);

            return $this->sendResponse($transaction, 'Transaction created successfully');
        } catch (ValidationException $e) {
            $errors = $e->errors();
            return $this->sendError('Validation Error', $errors, 422);
        }
    }

    public function getTransactions()
    {
        try {
            $user = Auth::user();
            $transactions = $user->transactions;

            return $this->sendResponse($transactions, 'Transactions retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Error fetching transactions', $e->getMessage(), 500);
        }
    }

    public function updateTransaction(Request $request, $transactionId)
    {
        try {
            $request->validate([
                'amount' => 'nullable|numeric',
                'type' => 'nullable|string',
                'description' => 'nullable|string',
            ]);

            $user = Auth::user();
            $transaction = $this->transactionRepository->findUserTransactionById($user->id, $transactionId);

            if (empty($transaction)) {
                return $this->sendError('Transaction not found');
            }

            $transaction->update($request->all());

            return $this->sendResponse($transaction, 'Transaction updated successfully');
        } catch (ValidationException $e) {
            $errors = $e->errors();
            return $this->sendError('Validation Error', $errors, 422);
        }
    }

    public function deleteTransaction($transactionId)
    {
        try {
            $user = Auth::user();
            $transaction = $this->transactionRepository->findUserTransactionById($user->id, $transactionId);

            $this->transactionRepository->delete($transaction);

            return $this->sendResponse([], 'Transaction deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError('Error deleting transaction', $e->getMessage(), 500);
        }
    }
}

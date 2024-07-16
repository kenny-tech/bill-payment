<?php

namespace App\Http\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    public function create(array $data) : Transaction
    {
        return Transaction::create($data);
    }

    public function findUserTransactionById($userId, $transactionId)
    {
        return Transaction::where('user_id', $userId)->where('id', $transactionId)->first();
    }

    public function update(Transaction $transaction, array $data)
    {
        $transaction->update($data);
        return $transaction;
    }

    public function delete(Transaction $transaction)
    {
        return $transaction->delete();
    }
}

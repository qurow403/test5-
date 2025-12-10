<?php

namespace App\Http\Controllers;

use App\Mail\TransactionCompletedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Transaction;

class RatingController extends Controller
{
    public function submit(Request $request)
    {
        try {
            $request->validate([
                'transaction_id' => 'required|exists:transactions,id',
                'rating' => 'required|integer|min:1|max:5',
            ]);

            $transaction = Transaction::findOrFail($request->transaction_id);
            $userId = auth()->id();

            Log::info('Rating submit', [
                'user_id' => $userId,
                'transaction_id' => $transaction->id,
                'rating' => $request->rating,
            ]);

            $role = $transaction->buyer_id === $userId ? 'buyer' : 'seller';

            if ($role === 'buyer') {
                $transaction->buyer_rating = $request->rating;
                $transaction->buyer_rated_at = now();
            } else {
                $transaction->seller_rating = $request->rating;
                $transaction->seller_rated_at = now();
            }

            $transaction->save();

            if ($role === 'buyer' && !$transaction->is_completed) {
                $transaction->is_completed = true;
                $transaction->save();

                Mail::to($transaction->seller->email)
                    ->send(new TransactionCompletedMail($transaction));

                Log::info('Transaction completed mail sent', [
                    'transaction_id' => $transaction->id,
                    'to' => $transaction->seller->email,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => '評価を送信しました'
            ]);

        } catch (\Exception $e) {
            Log::error('Rating submit failed', [
                'error' => $e->getMessage(),
                'all' => $request->all()
            ]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}

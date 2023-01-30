<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;

class AccountController extends Controller
{
    public function deposit(Request $request)
    {
        //We turn 500 when it falls into any error.
        try {
            //I throw the total amounts of user_ids in account in the account..
            $userAmount = Account::where(
                'user_id',
                auth('sanctum')->user()->id
            )->sum('amount');

            $balance = $request->amount;

            if ($userAmount < 0) {
                $balance = $balance * 0.2;
                $balance = $request->amount - $balance;
            }

            //I recorded user_id and amount in the account
            //I did it because I couldn't find the user on the session.
            Account::create([
                'amount' => $balance,
                'user_id' => auth('sanctum')->user()->id,
            ]);
            //I returned the message as json.
            return response()->json(
                [
                    'message' => 'Deposited.',
                ],
                200
            );
        } catch (\Throwable $th) {
            //If there is any error in TRY, I turn it 500.
            return response()->json(
                [
                    'message' => 'The money was not deposited.',
                ],
                500
            );
        }
    }

    public function withdraw(Request $request)
    {
        try {
            //I throw the total amounts of user_ids in account in the account..
            $userAmount = Account::where(
                'user_id',
                auth('sanctum')->user()->id
            )->sum('amount');
            //I wrote the total amount of the money he wanted to withdraw to check if he was greater than -500.
            $userAmount = $userAmount - $request->amount;

            //500 TL can be withdrawn at once.
            if ($request->amount <= 500) {
                //If the user's total amount is less than -500, he cannot withdraw money.
                if ($userAmount < -500) {
                    return response()->json(
                        [
                            'message' => 'Insufficient balance.',
                        ],
                        500
                    );
                }
                //I created user_id and amount in the account
                Account::create([
                    'amount' => -$request->amount,
                    'user_id' => '1',
                ]);
                //I returned the message as json.
                return response()->json(
                    [
                        'message' => 'Money deposited.',
                    ],
                    200
                );
            }
            //If the user wants to withdraw more than 500 TL, I return the message as json.
            return response()->json(
                [
                    'message' => 'Withdrawal Limit is 500 TL.',
                ],
                500
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'The money was not deposited.',
                ],
                500
            );
        }
    }

    public function balance()
    {
        $balance = Account::where('user_id', auth('sanctum')->user()->id)->sum(
            'amount'
        );
        return response()->json([
            'balance' => $balance,
        ]);
    }
}

<?php


namespace App\Services;


use App\Models\Transaction;

class TransactionService
{

    public function transaction($user,$type,$amount,$remarks){
        $transaction = new Transaction();
        $transaction->user_id = $user;
        $transaction->trx_type = $type;
        $transaction->amount = $amount;
        $transaction->remarks = $remarks;
        $transaction->trx_id = strRandom();
        $transaction->charge = 0;
        $transaction->save();
        return $transaction->trx_id ;
    }
}

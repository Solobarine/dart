<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deposit;
use App\Models\Message;
use App\Models\User;

class DepositController extends Controller
{
  //
  public function show (Request $request) {
    $deposits = Deposit::where('account_no', $request->account_no)->get();
    if (count($deposits) == 0) {
      return json_encode(['response' => 'Sorry, you do not have any deposit history']);
    } else {
      return $deposits;
    }
  }

  public function create (Request $request) {
    $user = User::where('account_no', $request->input('accountNo'))->get(['first_name', 'last_name', 'account_no']);
    if (count($user) == 0) {
      return json_encode(['response' => 'Cannot Deposit Now. Try again later.']);
    } else {
      $deposit = new Deposit;

      $deposit->amount = $request->input('amount');
      $deposit->transaction_id = $this->generateTransactionId();
      $deposit->status = 'pending';
      $deposit->account_no = $request->accountNo;
      $deposit->save();
      $this->effectDeposit($deposit);
      return json_encode(['response' => 'Your transaction has been accepted. Please wait while we process yor transaction']);
    }
  }

  public function update($transaction_id) {
    $deposit = Deposit::where('transaction_id', $transaction_id)->get();

    $deposit->status = 'success';

    $deposit->save();

    return json_encode(['response' => 'Transaction Successful']);
  }

  public function generateTransactionId () {
    $id_template = 'DPT-';
    $unique_portion = rand(10000000, 99999999);
    $transaction_id = $id_template.strval($unique_portion) ;
    $find_transaction_id = Deposit::where('transaction_id', $transaction_id)->get();

    if (count($find_transaction_id) >= 1) {
      $this->generateTransactionId();
    }
    return $transaction_id;
  }

  public function effectDeposit ($deposit_summary) {
    $user_account_no = $deposit_summary->account_no;
    $user = User::where('account_no', $user_account_no)->get();
    $topup = $deposit_summary->amount;
    if (count($user) == 0) {
      $deposit_summary->status = 'rejected';
      $deposit_summary->save();
      return json_encode(['response' => 'Transaction Rejected']);
    } else { 
      $user->balance = $user->balance + $topup;
      $this->update($deposit_summary->transaction_id);
      $user->save();
      $message = new Message();
      $messages = [
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'amount' => $topup,
        'transaction_id' => $deposit_summary->transaction_id,
        'account_no' => $deposit_summary->account_no,
        'balance' => $user->balance
      ];
      $message->show($messages, 'deposit');
      return json_encode(['response' => 'Deposit Successful']);
    }
  }
}

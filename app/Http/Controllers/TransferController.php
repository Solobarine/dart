<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\Account;
use App\Models\Message;
use App\Models\User;

class TransferController extends Controller
{
  //
  public function show (Request $request) {
    $transfer_history = Transfer::where('account_no', $request->input('account_no'))->first();
    if ($transfer_history == null) {
      return 'No Transaction History';
    } else {
      return $transfer_history;
    }
  }

  public function create (Request $request) {
    $user = User::where('account_no', $request->input('sender_account_no'))->get(['first_name', 'last_name']);
    $user_2 = User::where('account_no', $request->input('receiver_account_no'))->get(['first_name', 'last_name']);
    if ($user != null && $user_2 != null) {
      $transfer = new Transfer;

      $transfer->amount = $request->input('amount');
      $transfer->transaction_id = $this->generateTransactionId();
      $transfer->sender_first_name = $request->input('sender_first_name');
      $transfer->sender_last_name = $request->input('sender_last_name');
      $transfer->sender_account_no = $request->input('sender_account_no');
      $transfer->card_no = $request->input('card_no');
      $transfer->receiver_first_name = $request->input('receiver_first_name');
      $transfer->receiver_last_name = $request->input('receiver_last_name');
      $transfer->receiver_account_no = $request->input('receiver_account_no');
      $transfer->status = 'pending';
      $invoice = json_decode($transfer, true);
      $invoice['pin'] = $request->pin;

      $transfer->save();
      $this->effectTransfer($invoice);
      return $invoice;
      /*return json_encode(['response' => 'Transfer Request Accepted']);*/
    } else {
      return json_encode(['response' => 'Invalid Account Number']);
   }
  }

  public function update ($transaction_id) {
    $transfer = Transfer::where('transaction_id', $transaction_id)->first();

    $transfer->status = 'success';

    $transfer->save();

    return json_encode(['response' => 'Transaction Successful']);
  }

  public function generateTransactionId () {
    $id_template = 'TSF-';
    $unique_portion = rand(10000000, 99999999);
    $transaction_id = $id_template.strval($unique_portion);
    $find_transaction_id = Transfer::where('transaction_id', $transaction_id)->first();

    if ($find_transaction_id != null) {
      $this->generateTransactionId();
    }
    return $transaction_id;
  }

  public function effectTransfer ($transfer_data) {
    $sender_account_no = $transfer_data['sender_account_no'];
    $receiver_account_no = $transfer_data['receiver_account_no'];

    $query_sender = Account::where('account_no', $sender_account_no)->first();
    $query_receiver = User::where('account_no', $receiver_account_no)->first();

    if ($query_sender ==  null || $query_receiver == null || $query_sender->card_no != $transfer_data['card_no'] || $transfer_data['pin'] != $query_sender->pin) {
      $cancel = Transfer::where('transaction_id', $transfer_data['transaction_id'])->first();
      $cancel->status = 'failed1';
      $cancel->save();
      return json_encode(['response' => 'Transaction Failed']);
    } else {
      $user = User::where('account_no', $sender_account_no)->first();
      $receiver = User::where('account_no', $receiver_account_no)->first();
      if ($user->balance < $transfer_data['amount']) {
        $cancel_transfer = Transfer::where('transaction_id', $transfer_data['transaction_id'])->first();
        $cancel_transfer->status = 'failed2';
        $cancel_transfer->save();
        return json_encode(['response' => 'Transaction Failed. Insufficient Funds']);
        } else {
          $user->balance = $user->balance - $transfer_data['amount'];
          $receiver->balance = $receiver->balance + $transfer_data['amount'];
          $this->update($transfer_data['transaction_id']);

          $user->save();
          $receiver->save();
          $message = new MessagesController;
          $messages = [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'account_no' => $user->account_no,
            'amount' => $transfer_data['amount'],
            'receiver_first_name' => $receiver->first_name,
            'receiver_last_name' => $receiver->last_name,
            'receiver_account_no' => $receiver_account_no
          ]; 
          $message->store($messages, 'transfer');
          return json_encode(['response' => 'Transaction Successful. Thank you for choosing us']);
        }
    }
  }
}

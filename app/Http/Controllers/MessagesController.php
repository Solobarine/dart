<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($transaction_details, $transaction_type)
    {
      $message = new Message;
      if ($transaction_type == 'deposit') { 
        $message->description = 'Deposit';
        $message->receiver_first_name = $transaction_details->first_name;
        $message->receiver_account_no = $transaction_details->account_no;
        $message->message = 'Dear ' + $transaction_details->first_name + ', your deposit request with transaction id of ' + $transaction_details->transaction_id + 'is successful and your account has been credited with $' + $transaction_details->topup + '. Your current balance is $' + $transaction_details->balance + '. Thank you for choosing us';
        $message->sender = 'Dart';
      } else {
        $message->description = 'Transfer';
        $message->receiver_first_name = $transaction_details->first_name;
        $message->receiver_last_name = $transaction_details->last_name;
        $message->receiver_account_no = $transaction_details->account_no;
        $message->message = 'Hello ' + $transaction_details->first_name + '. Your transfer of ' + $transaction_details->amount + ' to' + $transaction_details->receiver_first_name + '' +  $transaction_details->receiver_last_name + ' is successful. Thank you for choosing us.';
        $message->sender = 'Dart';

        $message_2 = new Message;
        $message_2->description = 'Transfer';
        $message_2->receiver_first_name = $transaction_details->receiver_first_name;
        $message_2->receiver_last_name = $transaction_details->receiver_last_name;
        $message_2->receiver_account_no = $transaction_details->receiver_account_no;
        $message_2->message = 'Hello ' + $transaction_details->receiver_first_name + '. Your acount has been credited with $' + $transaction_details->amount + ' by ' + $transaction_details->first_name + ' ' + $transaction_details->last_name + '. Thank you for choosing us.';
        $message_2->sender = 'Dart';
        $message_2->save();
      }
      $message->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}

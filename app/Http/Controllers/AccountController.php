<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\User;

class AccountController extends Controller
{
  //
  public function show (Request $request) {
    $account = Account::where('account_no', $request->input('account_no'))->get();
    if ($account = null) {
      return 'Account does not Exist';
    } else {
      return $account;
    }
  }

  public function store (Request $request) {
    $account = new Account;
    $account->first_name = $request->input('first_name');
    $account->last_name = $request->input('last_name');
    $account->account_no = $request->accountNo;
    $account->card_no = $this->generateCardNo();
    $account->pin = $request->pin;

    $account->save();
    return json_encode(['response' => 'Account Created Successfully', 'Cards' => $account]);
  }

  public function update (Request $request) {
    $account = Account::find($request->account_no);
    $user = User::find($request->account_no);
    if ($account == null) {
      return json_encode(['response' => 'Account does not exist']);
    } else {
      $account->first_name = $request->input('first_name');
      $account->last_name = $request->input('last_name');
      $user->first_name = $request->input('first_name');
      $user->last_name = $request->input('last_name');

      $account->save();
      $user->save();

      return json_encode(['response' => 'Data Updated']);
    }
  }

  public function destroy (Request $request) {
    $account = Account::where('account_no', $request->input('account_no'))->get();
    if ($request->input('pin') == $account['pin']) {
      $account->delete();
      return json_encode(['response' => 'Account Removed']);
    } else {
      return json_encode(['response' =>  'Unauthorised Request']);
    }
  }

  public function generateCardNo () {
    $card_no = rand(1010101010101010, 9999999999999999);
    $findCardNo = Account::where('card_no', $card_no)->get();
    if ($findCardNo != null) {
      [AccountController::class, 'generateCardNo'];
    }
    return $card_no;
  }
}

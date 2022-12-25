<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\Deposit;
use App\Models\Settings;
use App\Models\Transfer;
use Validator;

class UserController extends Controller
{
  //
  public function index ()
  {
    $users = User::all();
    return $users;
  }
  
  public function show (Request $request) {
    $user = User::where('password', $request->input('password'))->where('email', $request->input('email'))->get(['first_name', 'last_name', 'balance', 'account_no']);
    $data = json_decode($user, true);
    if (count($user) == 0) {
      return json_encode(['err' => 'Incorrect Email or Password']);
    } else {
      $account = Account::where('account_no', $data[0]['account_no'])->get();
      $deposit = Deposit::where('account_no', $data[0]['account_no'])->get();
      $transfer = Transfer::where('sender_account_no', $data[0]['account_no'])->get();
      $settings = Settings::where('account_no', $data[0]['account_no'])->get();;
      return json_encode([
        'userDetails' => $user,
        'accounts' => $account,
        'deposits' => $deposit,
        'transfers' => $transfer,
        'settings' => $settings
      ]);
    }
  }

  public function store (Request $request)
  {
    $check_user = User::where('email', $request->email)->get(['email', 'first_name']);
    if (count($check_user) >= 1) {
      return json_encode(['response' => 'Account already Exists']);
    } else {
      $user = new User;
      $user->first_name = $request->input('first_name');
      $user->last_name = $request->input('last_name');
      $user->email = $request->input('email');
      $user->password = $request->input('password');
      $user->phone_no = $request->input('phone_no');
      $user->country = $request->input('country');
      $user->state = $request->input('state');
      $user->city = $request->input('city');
      $user->address = $request->input('address');
      $user->date_of_birth = $request->input('date_of_birth');
      $user->sex = $request->input('gender');
      $user->account_no = $this->generateAccountNo();
      $user->balance = 0;
      $user->save();
      return json_encode(['response' => 'Account Created Sucessfully']);
    }
  }

  public function showOne (Request $request) {
    $user = User::where('account_no', $request->accountNo)->where('first_name', $request->firstName)->get();
    if (count($user) != 0) {
    $account = Account::where('account_no', $user->account_no)->get();
    $deposit = Deposit::where('account_no', $user->account_no)->get();
    $transfer = Transfer::where('account_no', $user->account_no)->get();
    $settings = Settings::where('account_no', $user->account_no)->get();
    return json_encode([
      'userDetails' => $user,
      'accounts' => $account,
      'deposits' => $deposit,
      'transfers' => $transfer,
      'settings' => $settings
    ]);
    } else {
      return json_encode(['err' => 'Invalid Email or Password']);
    }
  }

  public function generateAccountNo () {
    $account_template = 2200000000;
    $unique_portion = rand(10000000, 99999999);
    $account_no = $account_template + $unique_portion;
    $findAccNo = Account::where('account_no', $account_no)->get();
    if ($findAccNo != null) {
      [AccountController::class, 'generateAccountNo'];
    }
    return $account_no;
  }
}

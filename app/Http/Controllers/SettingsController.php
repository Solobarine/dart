<?php

namespace App\Http\Controllers;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
  //
  public function store (Request $request) {
    $account = User::where('account_no', $request->account_no)->get('account_no');
    $dara = json_decode($account, true);
    if (count($account) == 0/* || $data[0]['account_no'] == 'none'*/) {
      return json_encode(['status' => 'You must have an account to enjoy this feature']);
    } else {
      $settings = Settings::find($request->account_no);
      if ($settings == null) {
      $settings = new Settings;
      } else {
        $settings = $settings;
      } 
      if ($request->theme == 'dark') {
        $settings->account_no = $request->account_no;
        $settings->background_color_1 = '#090d0e';
        $settings->background_color_2 = '#15191a';
        $settings->background_color_3 = '#272b2c';
        $settings->background_color_4 = '#1c2021';
        $settings->color_1 = '#fff';
        $settings->color_2 = '#94925e';
        $settings->color_3 = '#3e4142';
      } else {
        $settings->account_no = $request->account_no;
        $settings->background_color_1 = '#e1f2f8';
        $settings->background_color_2 = '#f9f3fc';
        $settings->background_color_3 = '#f2f7f6';
        $settings->background_color_4 = '#ede';
        $settings->color_1 = '#427e7a';
        $settings->color_2 = '#1c3a3e';
        $settings->color_3 = '#b1babe';
      }
      $settings->save();
      return json_encode(['status' => 'Theme Changed', 'settings' => $settings]);
    }
  }
}

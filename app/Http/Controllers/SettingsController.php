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
    if (count($account) == 0) {
      return json_encode(['status' => 'You must have an account to enjoy this feature']);
    } else {
      $settings = Settings::where($request->account_no)->first();
      if ($settings == null) {
      $settings = new Settings;
      } else {
        $settings = $settings;
      } 
      if ($request->theme == 'dark') {
        $settings->account_no = $request->account_no;
        $settings->background_color_1 = '#18656a';
        $settings->background_color_2 = '#a53168';
        $settings->background_color_3 = '#04656a';
        $settings->background_color_4 = '#ff4081';
        $settings->background_color_5 = '#6f7378';
        $settings->color_1 = '#fff';
        $settings->color_2 = '#ede';
        $settings->color_3 = '#fff';
      } else {
        $settings->account_no = $request->account_no;
        $settings->background_color_1 = '#59bdbb';
        $settings->background_color_2 = '#fc9790';
        $settings->background_color_3 = '#f2f7f6';
        $settings->background_color_4 = '#ede';
        $settings->background_color_5 = '#fff';
        $settings->color_1 = '#427e7a';
        $settings->color_2 = '#ede';
        $settings->color_3 = '#000';
      }
      $settings->save();
      return json_encode(['status' => 'Theme Changed', 'settings' => $settings]);
    }
  }

  public function show (Request $request) {
    $theme = Settings::where('account_no', $request->account_no)->first();
    if ($theme == null) {
      return json_encode(['res' => 'No Saved Themes']);
    } else {
      return $theme;
    }
  }
}

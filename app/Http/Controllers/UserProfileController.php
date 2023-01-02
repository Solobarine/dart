<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
  //
  public function create (Request $request) {
    $picture = UserProfile::find($request->account_no);
    if ($picture == null) {
      $picture = new UserProfile;

      $picture->account_no = $request->account_no;
      $picture->picture = $request->picture;

      $picture->save();
      return json_encode(['status' => 'Profile Picture Created']);
    } else {
      $picture->picture = $request->picture;

      $picture->save();
      return json_encode(['status' => 'User Profile Updated']);
    }
  }

  public function show (Request $request) {
    $image = UserProfile::find($request->account_no);
    if ($image == null) {
      return json_encode(['status' => 'No Image found.Please Upload']);
    } else {
      return json_encode(['image' => $image->picture]);
    }
  }
}

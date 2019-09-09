<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;

function follows(Request $request)
{
     $username =  $request->input('username');
     try {
          $user = User::where('username', $username)->firstOrFail();
     } catch (ModelNotFoundException $exp) {
          return $this->responseFail('User doesn\'t exists');
     }
     // Find logged in User
     $id = Auth::id();
     $me = User::find($id);
     $me->following()->attach($user->id);
     return $this->responseSuccess();
}

function unfollows(Request $request)
{
     $username =  $request->input('username');
     try {
          $user = User::where('username', $username)->firstOrFail();
     } catch (ModelNotFoundException $exp) {
          return $this->responseFail('User doesn\'t exists');
     }
     // Find logged in User
     $id = Auth::id();
     $me = User::find($id);
     $me->following()->detach($user->id);
     return $this->responseSuccess();
}

function responseSuccess($message = '')
{
     return $this->response(true, $message);
}

function responseFail($message = '')
{
     return $this->response(false, $message);
}

function response($status = false, $message = '')
{
     return response()->json([
          'status' => $status,
          'message' => $message,
          ]);
}
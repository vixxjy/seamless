<?php

namespace App\Repositories\Authentication;
use App\Repositories\Authentication\AuthContract;
use App\User;

class EloquentAuthRepository implements AuthContract {
    public function addUser($request) {
      $user = new User([
      'name' => $request->input('name'),
      'email' => $request->input('email'),
      'password' => bcrypt($request->input('password'))
      ]);
      
      $user->save();

      return $user;
    }
}
<?php

namespace App\Repositories;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
	public static function save($validated, $id = null)
	{
		if ($id != NULL) {
			$user = User::findOrFail($id);
			$user->gifts()->delete();
		} else {
			$user = new User();
		}

		$user->name = $validated['name'];
        $user->email = $validated['email'];		
		$user->username = $validated['username'];
        
        if (isset($validated['password']) && $validated['password'] != null) {			
        	$user->password = Hash::make($validated['password']);
		}		

		if ($validated['gifts']) {
			$user->gifts()->createMany($validated['gifts']);
		}
        
        if (!$user->save()) {
        	return false;
        }

        return $user;
	}
}
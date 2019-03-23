<?php

namespace App\Repositories;

use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\GroupConfirmation;

class GroupRepository
{
	public static function save($validated)
	{		
		$group = new Group();
	
        $group->name = $validated['name'];
        $group->creator_id = auth()->user()->id;
       
        if ($group->save()) {
            $userIds = $validated['usersToAdd'];

            $userWithTokens = array();
            foreach($userIds as $user){
                $userWithTokens[$user] = ['token' => uniqid()];                
            }
            
            $group->participants()->attach($userWithTokens);

            foreach($group->participants as $participant){                
                Mail::to($participant->email)->send(new GroupConfirmation($participant, $group));
            }
            return $group;
        }
        
        return false;
	}
}
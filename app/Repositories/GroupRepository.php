<?php

namespace App\Repositories;

use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GroupRepository
{
	public static function save($validated)
	{		
		$group = new Group();
	
        $group->name = $validated['name'];
        $group->creator_id = auth()->user()->id;
       
        if ($group->save()) {
            $group->participants()->attach($validated['usersToAdd']);
            return $group;
        }
        
        return false;
	}
}
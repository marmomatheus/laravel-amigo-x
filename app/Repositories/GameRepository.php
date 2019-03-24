<?php

namespace App\Repositories;

use App\Game;
use App\Group;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\GameNotification;


class GameRepository
{
    private $confirmedParticipants = array();

	public function save($validated)
	{		
		$game = new Game();
	
        $game->name = $validated['name'];
        $game->group_id = $validated['group_id'];
        $game->exchange_date = Carbon::createFromFormat('d/m/Y', $validated['exchange_date'])->toDateString();
       
        if ($game->save()) {
            $matches = $this->generate($game->group_id, $validated['exchange_date']);   
            $game->matches()->createMany($matches);
            return $game;
        }
        
        return false;
    }
    
    public function generate($group, $date)
    {
        $group = Group::with('participants')->findOrFail($group);
       
        foreach($group->participants as $participant){
            if ($participant->pivot->confirmed) {
                array_push($this->confirmedParticipants,  $participant->pivot->user_id);
            }
        }        
        
        $matches = array();
        $participants = $this->confirmedParticipants;

        foreach($participants as $participant){
            $match = $this->matches($participant);

            $participantModel = User::select('email', 'name')
                                    ->where('id', $match['user_id'])
                                    ->first();
            $friendModel = User::with('gifts')
                                ->select('name')
                                ->where('id', $match['user_id'])
                                ->first();

            Mail::to($participantModel->email)->send(new GameNotification($group, $participantModel, $friendModel, $date));

            array_push($matches, $match);
        }

        return $matches;
    }

    public function matches($id)
    {            
        srand((float) microtime() * 10000000);
        $key = array_rand($this->confirmedParticipants);
        $friend =  $this->confirmedParticipants[$key];
		if ($friend != $id) {
            $match['user_id'] = $id;
            $match['friend_id'] = $friend;
            unset($this->confirmedParticipants[$key]);
			return $match;
        } else {
			return $this->matches($id);
		}        
    }
}
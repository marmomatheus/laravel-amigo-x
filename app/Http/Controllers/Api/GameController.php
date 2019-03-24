<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\GameRequest;
use App\Repositories\GameRepository;
use App\Game;

class GameController extends Controller
{
    public function index()
    {   
        return Game::with('group')->get();
    }
    
    public function show($id)
    {
       
    }

    public function store(GameRequest $requestGame, GameRepository $repositoryGame)
    {        
        $game = $repositoryGame->save($requestGame);
       
        if ($game) {                                  
            return response([
                'message' => 'Sucesso! Os participantes receberão por email o usuário sorteado.'
            ], 201);
        } else {
            return response(['error' => 'Não foi possível criar o jogo.'], 400);
        }       
    }

    public function update(GameRequest $requestGame, GameRepository $repositoryGame, $id)
    {
    }

    public function destroy($id)
    {
        //
    }
}

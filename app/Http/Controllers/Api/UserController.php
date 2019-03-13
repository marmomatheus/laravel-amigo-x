<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    public function index()
    {
        
    }
    
    public function show($id)
    {
        $user = User::with('gifts')->findOrFail($id);
        return $user;
    }

    public function store(Request $request)
    {
        //
    }

    public function update(UserRequest $requestUser, UserRepository $repositoryUser, $id)
    {
        $user = $repositoryUser->save($requestUser, $id);
        if ($user) {                                  
            return response([
                'message' => 'Sucesso!',                
                'user' => $user
            ], 201);
        } else {
            return response(['error' => 'Não foi possível atualizar o usuário.'], 400);
        }
    }

    public function destroy($id)
    {
        //
    }
}

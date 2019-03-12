<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;

class AuthController extends Controller
{  
    public function login(LoginRequest $request)
    {
        $attempt = Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], true);
        if ($attempt) {                   
            return response([
                'message' => 'Sucesso!',
                'user' => Auth::user()                
            ], 200);
        } else {
            return response(['error' => 'Dados Inválidos!'], 401);
        }
    }
  
    public function register(UserRequest $requestUser, UserRepository $repositoryUser)
    {         
        $user = $repositoryUser->save($requestUser);
        if ($user) {                                  
            return response([
                'message' => 'Sucesso!',                
                'user' => $user
            ], 201);
        } else {
            return response(['error' => 'Não foi possível adicionar um novo usuário.'], 400);
        }
    }
    
    public function logout()
    {
        return Auth::logout();        
    }
}
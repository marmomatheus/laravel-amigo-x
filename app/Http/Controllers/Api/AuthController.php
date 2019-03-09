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
    /**
     * Realiza uma tentativa de login
     *
     * @param  \App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $attempt = Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')]);
        if ($attempt) {            
            return response([
                'message' => 'Sucesso!',                
            ], 200);
        } else {
            return response(['error' => 'Dados Inválidos!'], 401);
        }
    }
  
    /**
     * Cria um novo usuário e sua respectiva empresa e retorna o token de autenticação.
     *
     * @param  \App\Http\Requests\UserRequest  $requestUser
     * @param  \App\Repositories\UserRepository $repositoryUser     
     * @return \Illuminate\Http\Response
     */
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
}
<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Group;
use App\Http\Requests\GroupRequest;
use App\Repositories\GroupRepository;

class GroupController extends Controller
{
    public function index()
    {   
        return Group::with(['participants', 'creator'])                    
                    ->whereHas('participants', function($q){
                        $q->where('group_user.user_id', auth()->user()->id);
                    })                    
                    ->get();
    }
    
    public function show($id)
    {
        $group = Group::with('participants')->findOrFail($id);
        return $group;
    }

    public function store(GroupRequest $requestGroup, GroupRepository $repositoryGroup)
    {
        $group = $repositoryGroup->save($requestGroup);
        if ($group) {                                  
            return response([
                'message' => 'Sucesso! Os usuários adicionados serão notificados.'
            ], 201);
        } else {
            return response(['error' => 'Não foi possível criar o grupo.'], 400);
        }        
    }

    public function update(GroupRequest $requestGroup, GroupRepository $repositoryGroup, $id)
    {
    }

    public function destroy($id)
    {
        //
    }
}

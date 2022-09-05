<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoleService;

class RoleController extends Controller
{
    public $success = 200;
    public $unauth = 401;
    public $error = 500;
    public $conflict = 409;

    protected $roleService;

    public function __construct(RoleService $roleService){
        $this->roleService = $roleService;
    }

    public function data(Request $request)
    {   
        $reqParams = $request->all();

        if($request->keyword){
            $keys = ['name' => $request->keyword];
            $reqParams = array_merge($reqParams,$keys);
        }
        
        try{
            $query = $this->roleService->data($reqParams);
            if($request->page){
              $result = $query->paginate($request->rowsPerPage);
            }else{
              $result = $query->get();
            }
            return response($result);
          }catch(\Exception $e){
            return response(['error'=>$e->getMessage(), 'message'=>'failed get data']);
        }
    }

    public function getForOptions(Request $request) {
        try {
            $query = $this->roleService->getForOptions($request);
            return response($query);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
        }
    }

    public function getUsersOfRole(Request $request) {
        try {
            $query = $this->roleService->getUsersOfRole($request->role_id);
            return response($query);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
        }
    }

    public function getForMenus() {
        try {
            $query = $this->roleService->getForMenus();
            return response($query);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
        }
    }

    public function getForActions() {
        try {
            $query = $this->roleService->getForActions();
            return response($query);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
        }
    }

    public function getApprovalsOfRole(Request $request) {
        
        try {
            $query = $this->roleService->getApprovalsOfRole($request->role_id);
            return response($query);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
        }
    }


    public function store(Request $request)
    {   
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'data_access_value' => 'required'
        ]);

        $result = $this->roleService->store($request->all());

        if($result){
            return response()->json(['message'=>'stored data'], $this->success);
        }else{
            return response()->json(['errors'=>['store'=>'stored failed']], $this->error);
        }
    }

    public function addApproval(Request $request)
    {
        try {
            $result = $this->roleService->addApproval(
                $request->role_id, 
                $request->action_id, 
                $request->level
            );
            
            if ($result==='save') {
                return response(['message' => 'stored data'], $this->success);
              } else {
                return response()->json(['errors' => ['store' => 'duplicated']], $this->error);
              }
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage(), 'message' => 'failed save data']);
        }
    }

    public function storePriviledge(Request $request){

        $request->validate([
            'role_id' => 'required',
        ]);

        $result = $this->roleService->storePriviledge($request);

        if($result){
            return response()->json(['message'=>'stored data'], $this->success);
        }else{
            return response()->json(['errors'=>['store'=>'stored failed']], $this->error);
        }

    }

    public function addUserOfRole(Request $request){

        $request->validate([
            'role_id' => 'required',
            'user_ids' => 'required',
        ]);

        $result = $this->roleService->addUserOfRole($request->role_id, $request->user_ids);

        if($result){
            return response()->json(['message'=>'stored data'], $this->success);
        }else{
            return response()->json(['message'=>'duplicated data'], $this->success);
        }

    }

    public function detail($id)
    {
        $result = $this->roleService->detail($id);
        return $result;
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'data_access_value' => 'required'
        ]);

        $data = [
            "head_role_id"=> $request->head_role_id,
            "name"=> $request->name,
            "code"=> $request->code,
            "data_access_value"=> $request->data_access_value,
            "is_head"=> $request->is_head,
            "role_level_value"=> $request->role_level_value,
            "unit_id"=> $request->unit_id,
            "subtitute_role_id"=> $request->subtitute_role_id
        ];

        $result = $this->roleService->update($request->id, $data);

        if($result){
            return response()->json(['message'=>'changed data'], $this->success);
        }else{
            return response()->json(['errors'=>['update'=>'change failed']], $this->error);
        } 
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'ids' => 'required',
        ]);

        $result = $this->roleService->destroy($request);

        if($result){
            return response()->json(['message'=>'delete data'], $this->success);
        }else{
            return response()->json(['errors'=>['delete'=>'delete failed']], $this->error);
        }
    }

    public function deleteUserOfRole(Request $request)
    {
        $request->validate([
            'role_id' => 'required',
            'user_ids' => 'required',
        ]);

        $result = $this->roleService->deleteUserOfRole($request->role_id, $request->user_ids);

        if($result){
            return response()->json(['message'=>'delete data'], $this->success);
        }else{
            return response()->json(['errors'=>['delete'=>'delete failed']], $this->error);
        }
    }

    public function deleteApprovalOfRole(Request $request){
        
        $request->validate([
            'role_id' => 'required',
            'action_ids' => 'required',
        ]);

        $result = $this->roleService->deleteApprovalOfRole($request->role_id, $request->action_ids);

        if ($result) {
            return response()->json(['message' => 'delete data'], $this->success);
        }else {
            return response()->json(['errors' => ['delete' => 'delete failed']], $this->error);
        }
    }

}

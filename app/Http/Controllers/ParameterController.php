<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ParameterService;

class ParameterController extends Controller
{
    public $success = 200;
    public $unauth = 401;
    public $error = 500;
    public $conflict = 409;

    protected $parameterService;

    public function __construct(parameterService $parameterService){
        $this->parameterService = $parameterService;
    }

    public function data(Request $request)
    {   
        $reqParams = $request->all();

        try{
            $query = $this->parameterService->data($reqParams);
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

    public function getForOptions(Request $request)
    {
       try {
        return $this->parameterService->getForOptions($request->group);         
        } catch (\Exception $e) {
        return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
        }
    }


    public function store(Request $request)
    {   
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'group' => 'required',
            'value' => 'required'
        ]);

        $result = $this->parameterService->store($request);

        if($result){
            return response()->json(['message'=>'stored data'], $this->success);
        }else{
            return response()->json(['errors'=>['store'=>'stored failed']], $this->error);
        }
    }

    public function detail($id)
    {
        $result = $this->parameterService->detail($id);
        return $result;
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'group' => 'required',
            'value' => 'required'
        ]);

        $result = $this->parameterService->update($request);

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

        $result = $this->parameterService->destroy($request);

        if($result){
            return response()->json(['message'=>'delete data'], $this->success);
        }else{
            return response()->json(['errors'=>['delete'=>'delete failed']], $this->error);
        }
    }

}

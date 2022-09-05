<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ActionService;
use App\Services\ApplicationCategoriesService;
use Illuminate\Support\Facades\DB;

class ApplicationCategoriesController extends Controller
{
    protected $applicationCategoriesService;

    public function __construct(ApplicationCategoriesService $applicationCategoriesService)
    {
        $this->applicationCategoriesService = $applicationCategoriesService;
    }

    public function insertAplicationCategories(Request $request)
    {
        $data = $request->all();
        try {
            DB::beginTransaction();
            foreach ($data["apps"] as $key) {
                $payload = [
                    'category_id' => $data["categoryId"],
                    'application_id' => $key["id"]
                ];
                $this->applicationCategoriesService->insertApplicationCategories($payload);
            }

            DB::commit();
            return response([
                'message' => "Success"
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getApplicationCategories(Request $request)
    {
        $data = $request->all();

        return $this->applicationCategoriesService->getApplicationCategories($data);
    }

    public function deleteApplicationCategories(Request $request)
    {
        try {
            $data = $request->all();
            DB::beginTransaction();
            $this->applicationCategoriesService->deleteApplicationCategories($data);
            DB::commit();
            return response([
                'message' => 'Success'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}

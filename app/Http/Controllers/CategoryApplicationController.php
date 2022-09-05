<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ActionService;
use App\Services\ApplicationCategoriesService;
use App\Services\CategoryApplicationService;
use Illuminate\Support\Facades\DB;

class CategoryApplicationController extends Controller
{
    protected $categoryApplicationController;
    protected $applicationCategoryService;

    public function __construct(CategoryApplicationService $categoryApplicationController, ApplicationCategoriesService $applicationCategoriesService)
    {
        $this->categoryApplicationController = $categoryApplicationController;
        $this->applicationCategoryService = $applicationCategoriesService;
    }

    public function insertCategory(Request $request)
    {
        $data = $request->all();
        try {
            $this->categoryApplicationController->insertCategory($data);
            return response([
                'message' => "Success"
            ], 200);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getCategory(Request $request)
    {
        $data = $request->all();
        return $this->categoryApplicationController->getCategory($data, $request->rowPerPage);
    }

    public function updateCategory(Request $request)
    {
        try {
            $data = [
                'name' => $request->name
            ];
            $this->categoryApplicationController->editCategory($request->id, $data);
            return response([
                'message' => "Success"
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function deleteCategory(Request $request)
    {
        $data = $request->all();
        try {
            DB::beginTransaction();
            foreach ($data["ids"] as $key) {
                $this->applicationCategoryService->deleteCategories($key);
                $this->categoryApplicationController->deleteCategory($key);
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
}

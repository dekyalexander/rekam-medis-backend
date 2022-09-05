<?php

namespace App\Services;

use App\Models\EmployeeCareer;
use App\Repositories\ApplicationCategoriesRepository;
use App\Repositories\EmployeeCareerRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class ApplicationCategoriesService
{
    protected $applicationCategoriesService;

    public function __construct(ApplicationCategoriesRepository $applicationCategoriesService)
    {
        $this->applicationCategoriesService = $applicationCategoriesService;
    }

    public function getApplicationCategories($filter)
    {
        return $this->applicationCategoriesService->getApplicationCategories($filter)->get();
    }

    public function insertApplicationCategories($data)
    {
        $this->applicationCategoriesService->insertApplicationCategory($data);
    }

    public function deleteApplicationCategories($request)
    {
        foreach ($request['applicationId'] as $key) {
            $this->applicationCategoriesService->deleteAplicationFromCategory($key);
        }
    }

    public function deleteCategories($id)
    {
        $this->applicationCategoriesService->deleteByCategoryId($id);
    }
}

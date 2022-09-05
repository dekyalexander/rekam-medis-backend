<?php

namespace App\Services;

use App\Models\EmployeeCareer;
use App\Repositories\CategoryApplicationRepository;
use App\Repositories\EmployeeCareerRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class CategoryApplicationService
{
    protected $categoryApplicationService;

    public function __construct(CategoryApplicationRepository $categoryApplicationService)
    {
        $this->categoryApplicationService = $categoryApplicationService;
    }

    public function getCategory($filter, $rowPerPage)
    {
        return $this->categoryApplicationService->getCategoryOption($filter)->paginate($rowPerPage);
    }

    public function insertCategory($data)
    {
        $this->categoryApplicationService->insertCategory($data);
    }

    public function editCategory($id, $data)
    {
        $this->categoryApplicationService->editCategory($id, $data);
    }

    public function deleteCategory($id)
    {
        $this->categoryApplicationService->deleteCategory($id);
    }
}

<?php

namespace App\Repositories;

use App\Models\ApplicationCategories;
use App\Models\CategoryApplication;
use App\Models\EmployeeCareer;

class ApplicationCategoriesRepository
{
    protected $applicationCategory;

    public function __construct(ApplicationCategories $applicationCategory)
    {
        $this->applicationCategory = $applicationCategory;
    }

    public function insertApplicationCategory($data)
    {
        $this->applicationCategory->create($data);
    }

    public function getApplicationCategories($filters)
    {
        return $this->applicationCategory->with(['applications'])
            ->when(isset($filters['categoryId']), function ($query) use ($filters) {
                return $query->where('category_id', $filters['categoryId']);
            })->when(isset($filters['applicationId']), function ($query) use ($filters) {
                return $query->where('application_id', $filters['applicationId']);
            });
    }

    public function deleteAplicationFromCategory($id)
    {
        $this->applicationCategory->where('id', $id)->delete();
    }

    public function deleteByCategoryId($id)
    {
        ApplicationCategories::where('category_id', $id)->delete();
    }
}

<?php

namespace App\Repositories;

use App\Models\CategoryApplication;
use App\Models\EmployeeCareer;

class CategoryApplicationRepository
{
    protected $categoryApplication;

    public function __construct(CategoryApplication $categoryApplication)
    {
        $this->categoryApplication = $categoryApplication;
    }

    public function insertCategory($data)
    {
        $this->categoryApplication->create($data);
    }

    public function getCategoryOption($filters)
    {
        return $this->categoryApplication->when(isset($filters['categoryId']), function ($query) use ($filters) {
            return $query->where('id', $filters['categoryId']);
        })
            ->orderBy('name', 'ASC');
    }

    public function deleteCategory($id)
    {
        CategoryApplication::where('id', $id)->delete();
    }

    public function editCategory($id, $data)
    {
        $this->categoryApplication->where('id', $id)->update($data);
    }
}

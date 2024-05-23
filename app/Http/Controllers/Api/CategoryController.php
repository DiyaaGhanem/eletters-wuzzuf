<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CategoryRequest;
use App\Http\Requests\Api\DeleteCategoryRequest;
use App\Http\Requests\Api\GetCategoryByIdRequest;
use App\Http\Requests\Api\RestoreCategoryRequest;
use App\Http\Requests\Api\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Traits\Responses;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;


class CategoryController extends Controller
{
    use Responses;

    public function index()
    {
        $categories = Category::orderBy('id', 'DESC')->with('parent')->with('subCategories.subCategories')->paginate(10);

        return $this->successPaginated(data: CategoryResource::collection($categories), status: Response::HTTP_OK, message: 'All Categories.');
    }

    public function createCategory(CategoryRequest $request)
    {
        $data = $request->all();
        $data['parent_id'] = $request->parent_id ?? NULL;

        $category = Category::create($data);

        return $this->success(status: Response::HTTP_OK, message: 'Category Created Successfully!!.', data: new CategoryResource($category));
    }

    public function updateCategory(UpdateCategoryRequest $request)
    {
        $data = $request->all();
        $category = Category::where('id', $data['category_id'])->with('parent')->with('subCategories.subCategories')->first();
        $data['parent_id'] = $request->parent_id ?? NULL;
        $category->update($data);

        return $this->success(status: Response::HTTP_OK, message: 'Category Updated Successfully!!.', data: new CategoryResource($category));
    }

    public function softDeleteCategory(DeleteCategoryRequest $request)
    {
        $data = $request->all();
        $category = Category::find($data['category_id']);

        if (is_null($category)) {
            return $this->error(status: Response::HTTP_OK, message: 'Category Already Deleted!!.');
        }

        $category->delete();
        return $this->success(status: Response::HTTP_OK, message: 'Category Deleted Successfully!!.', data: new CategoryResource($category));
    }

    public function restoreCategory(RestoreCategoryRequest $request)
    {
        $data = $request->all();
        $category = Category::withTrashed()->find($data['category_id']);

        if (!is_null($category->deleted_at)) {
            $category->restore();
            return $this->success(status: Response::HTTP_OK, message: 'Category Restored Successfully!!.', data: new CategoryResource($category));
        }

        return $this->success(status: Response::HTTP_OK, message: 'Category Already Restored!!.', data: new CategoryResource($category));
    }

    public function getCategoryById(GetCategoryByIdRequest $request)
    {
        $data = $request->all();
        $category = Category::where('id', $data['category_id'])->with(['parent', 'jobs', 'subCategories.subCategories'])->first();

        return $this->success(status: Response::HTTP_OK, message: 'Category Details.', data: new CategoryResource($category));
    }
}

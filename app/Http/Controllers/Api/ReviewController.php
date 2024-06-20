<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetApplicationByIdRequest;
use App\Http\Requests\Api\GetReviewByIdRequest;
use App\Http\Requests\Api\ReviewRequest;
use App\Http\Requests\Api\UpdateReviewRequest;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\ReviewResource;
use App\Models\Application;
use App\Models\Review;
use App\Traits\Responses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    use Responses;

    public function index()
    {
        $reviews = Review::with(['application', 'application.user', 'interview'])->orderBy('id', 'DESC')->paginate(10);

        return $this->successPaginated(data: ReviewResource::collection($reviews), status: Response::HTTP_OK, message: 'All Reviews.');
    }

    public function createReview(ReviewRequest $request)
    {
        $data = $request->all();
        $review = Review::create($data);

        $review->load('application', 'application.user');

        return $this->success(status: Response::HTTP_OK, message: 'Review Created Successfully!!.', data: new ReviewResource($review));
    }

    public function updateReview(UpdateReviewRequest $request)
    {
        $data = $request->all();
        $review = Review::findOrFail($data['review_id']);
        $review->update($data);

        return $this->success(status: Response::HTTP_OK, message: 'Review Updated Successfully!!.', data: new ReviewResource($review));
    }

    public function softDeleteReview(GetReviewByIdRequest $request)
    {

        $data = $request->all();
        $review = Review::find($data['review_id']);

        if (is_null($review)) {
            return $this->error(status: Response::HTTP_OK, message: 'Review Already Deleted!!.');
        }

        $review->delete();
        return $this->success(status: Response::HTTP_OK, message: 'Review Deleted Successfully!!.', data: new ReviewResource($review));
    }

    public function restoreReview(GetReviewByIdRequest $request)
    {

        $data = $request->all();
        $review = Review::withTrashed()->find($data['review_id']);

        if (!is_null($review->deleted_at)) {
            $review->restore();
            return $this->success(status: Response::HTTP_OK, message: 'Review Restored Successfully!!.', data: new ReviewResource($review));
        }

        return $this->success(status: Response::HTTP_OK, message: 'Review Already Restored!!.', data: new ReviewResource($review));
    }

    public function getReviewById(GetReviewByIdRequest $request)
    {
        $data = $request->all();
        $review = Review::where('id', $data['review_id'])->with('application', 'interview')->first();

        return $this->success(status: Response::HTTP_OK, message: 'Review Details.', data: new ReviewResource($review));
    }

    public function getReviewByApplicationId(GetApplicationByIdRequest $request)
    {
        $data = $request->all();
        $application = Application::where('id', $data['application_id'])->with('job', 'user', 'reviews')->first();

        return $this->success(status: Response::HTTP_OK, message: 'All Applications Reviews Details.', data: new ApplicationResource($application));
    }
}

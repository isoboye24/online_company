<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ReviewController extends Controller
{
    public function index(){
        $reviews = Review::latest()->get();
        return view('admin/backend/reviews.index', compact('reviews'));
    }

    public function create(){
        return view('admin/backend/reviews.create');
    }

    public function store(StoreReviewRequest $request){
        $reviewData = $request->validated();
        Review::create($reviewData);
        return redirect()->route('admin/reviews.index');
    }

    public function show(){

    }

    public function edit(){

    }

    public function update(){

    }

    public function delete(){

    }
}
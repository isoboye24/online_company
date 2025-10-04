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

    public function store(Request $request){

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(60,60)->save(public_path('upload/review/'.$name_gen));
            $save_url = 'upload/review/'.$name_gen;

            Review::create([
                'name' => $request->name,
                'position' => $request->position,
                'message' => $request->message,
                'image' => $save_url ?? 'upload/no_image.jpg',
            ]);

            $notification = array(
                'message' => 'Review Inserted Successfully',
                'alert-type' => 'success'
            );
        }
        else{
            $notification = array(
                    'message' => 'Please, fill up all the fields',
                    'alert-type' => 'warning'
                );
        }


        return redirect()->route('admin.backend.reviews.index')->with($notification);
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
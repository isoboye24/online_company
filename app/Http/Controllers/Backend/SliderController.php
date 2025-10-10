<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SliderController extends Controller
{
    public function index(){
        $sliders = Slider::latest()->get();
        return view('admin.backend.sliders.index', compact('sliders'));
    }

    public function create(){
        return view('admin.backend.sliders.create');
    }

    public function store(Request $request){
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(306,618)->save(public_path('upload/slider/'.$name_gen));
            $save_url = 'upload/slider/'.$name_gen;

            Slider::create([
                'title' => $request->title,
                'link' => $request->link,
                'description' => $request->description,
                'image' => $save_url ?? 'upload/no_image.jpg',
            ]);

            $notification = array(
                'message' => 'Slider Inserted Successfully',
                'alert-type' => 'success'
            );
        }
        else{
            $notification = array(
                    'message' => 'Please, fill up all the fields',
                    'alert-type' => 'warning'
                );
        }
        return redirect()->route('admin.backend.sliders.index')->with($notification);
    }

    public function edit($id){
        $slider = Slider::find($id);
        return view('admin/backend/sliders.edit', compact('slider'));
    }

    public function update(Request $request){
        $slider_id = $request->id;
        $slider = Slider::find($slider_id);

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(306,618)->save(public_path('upload/slider/'.$name_gen));
            $save_url = 'upload/slider/'.$name_gen;

            // Delete image safely
            if ($slider->image && file_exists(public_path($slider->image))) {
                unlink(public_path($slider->image));
            }

            Slider::find($slider_id)->update([
                'title' => $request->title,
                'link' => $request->link,
                'description' => $request->description,
                'image' => $save_url ?? 'upload/no_image.jpg',
            ]);

            $notification = array(
                'message' => 'Slider Updated Successfully',
                'alert-type' => 'success'
            );
        }
        else{
            Slider::find($slider_id)->update([
                'title' => $request->title,
                'link' => $request->link,
                'description' => $request->description,
            ]);

            $notification = array(
                'message' => 'Slider Updated without Successfully',
                'alert-type' => 'success'
            );
        }

        return redirect()->route('admin.backend.sliders.index')->with($notification);
    }

    public function destroy($id){
        $item = Slider::find($id);

        if (!$item) {
            return redirect()->route('admin.backend.sliders.index')->with([
                'message' => 'Slider not found',
                'alert-type' => 'error'
            ]);
        }

        // Delete image safely
        if ($item->image && file_exists(public_path($item->image))) {
            unlink(public_path($item->image));
        }

        $item->delete();

        return redirect()->route('admin.backend.sliders.index')->with([
            'message' => 'Slider deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}
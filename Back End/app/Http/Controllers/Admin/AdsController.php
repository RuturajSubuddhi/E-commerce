<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ads;

class AdsController extends Controller
{
    public function index()
    {
        $adsList = Ads::all();
        return view('adminPanel.ads.ads_list', compact('adsList'));
    }

    public function create()
    {
        return view('adminPanel.ads.create');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
    //         'link' => 'nullable|url',
    //     ]);

    //     $path = null;
    //     if ($request->hasFile('image')) {
    //         $path = $request->file('image')->store('ads', 'public');
    //     }

    //     Ads::create([
    //         'title' => $request->title,
    //         'image' => $path,
    //         'link' => $request->link,
    //     ]);

    //     return redirect()->route('adminPanel.ads.ads_list')->with('success', 'Ad created successfully!');
    // }


    public function store(Request $request)
    {
        $request->validate([
            'position'   => 'required',
            'banner_img' => 'required',   // base64 image
        ]);

        // convert base64 to image file
        $base64Image = $request->banner_img;

        $imageName = 'ads_' . time() . '.png';
        $imagePath = public_path('uploads/ads/' . $imageName);

        // create folder if not exist
        if (!file_exists(public_path('uploads/ads'))) {
            mkdir(public_path('uploads/ads'), 0777, true);
        }

        // decode base64 and store
        $imageData = base64_decode(str_replace(
            'data:image/png;base64,',
            '',
            $base64Image
        ));

        file_put_contents($imagePath, $imageData);

        // save data into database
        Ads::create([
            'position'   => $request->position,
            'img'        => 'uploads/ads/' . $imageName,
            'is_popular' => $request->is_popular ?? 0,
        ]);

        return redirect()->back()->with('success', 'Ads Created Successfully!');
    }


    public function edit($id)
    {
        $ad = Ads::findOrFail($id);
        return view('adminPanel.ads.edit', compact('ad'));
    }

    // public function update(Request $request, $id)
    // {
    //     $ad = Ads::findOrFail($id);

    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
    //         'link' => 'nullable|url',
    //     ]);

    //     $path = $ad->image;
    //     if ($request->hasFile('image')) {
    //         $path = $request->file('image')->store('ads', 'public');
    //     }

    //     $ad->update([
    //         'title' => $request->title,
    //         'image' => $path,
    //         'link' => $request->link,
    //     ]);

    //     return redirect()->route('adminPanel.ads.ads_list')->with('success', 'Ad updated successfully!');
    // }

    public function update(Request $request, $id)
    {
        $ad = Ads::findOrFail($id);

        $request->validate([
            'position' => 'required',
        ]);

        $imagePath = $ad->img; // keep old image path by default

        if ($request->filled('updateImage')) {
            $base64Image = $request->updateImage;

            $imageName = 'ads_' . time() . '.png';
            $uploadPath = public_path('uploads/ads/');

            // create folder if not exists
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // decode base64 and save
            $imageData = base64_decode(str_replace('data:image/png;base64,', '', $base64Image));
            file_put_contents($uploadPath . $imageName, $imageData);

            // optionally delete old image
            if (file_exists(public_path($ad->img))) {
                unlink(public_path($ad->img));
            }

            $imagePath = 'uploads/ads/' . $imageName;
        }

        $ad->update([
            'position'   => $request->position,
            'img'        => $imagePath,
            'is_popular' => $request->has('is_popular') ? 1 : 0, // handle checkbox
        ]);

         return redirect()->back()->with('success', 'Ads updated Successfully!');
    }



    public function destroy($id)
    {
        $ad = Ads::findOrFail($id);
        $ad->delete();

        return back()->with('success', 'Ad deleted successfully!');
    }
}

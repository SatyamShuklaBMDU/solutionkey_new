<?php

namespace App\Http\Controllers;

use App\Models\UserBanner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = UserBanner::all();
        return view('banners.index',compact('banners'));
    }

    public function getBanners(Request $request)
    {
        $banners = UserBanner::all();
        return response()->json($banners);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'for' => 'required|string|max:255',
            'image' => 'required|image',
        ]);
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $photoFileName = uniqid() . '.' . $request->image->extension();
            $photoPath = $request->file('image')->move(public_path('Banner'), $photoFileName);
            $photoRelativePath = 'Banner/' . $photoFileName;
            $validated['image'] = $photoRelativePath;
        }
        UserBanner::create($validated);
        return response()->json(['success' => 'Banner created successfully.']);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'for' => 'required|string|max:255',
            'image' => 'required|image',
        ]);

        $banner = UserBanner::findOrFail($id);
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $photoFileName = uniqid() . '.' . $request->image->extension();
            $photoPath = $request->file('image')->move(public_path('Banner'), $photoFileName);
            $photoRelativePath = 'Banner/' . $photoFileName;
            $validated['image'] = $photoRelativePath;
        }
        $banner->update($validated);
        return response()->json(['success' => 'Banner updated successfully.']);
    }

    public function destroy($id)
    {
        $banner = UserBanner::findOrFail($id);
        $banner->delete();

        return response()->json(['success' => 'Banner deleted successfully.']);
    }

    public function updateStatus(Request $request, $id)
    {
        $banner = UserBanner::findOrFail($id);
        $banner->status = $request->status;
        $banner->save();

        return response()->json(['success' => 'Status updated successfully.']);
    }

}

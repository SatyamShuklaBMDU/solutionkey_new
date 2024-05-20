<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\SubService;
use Illuminate\Http\Request;

class SubServicesController extends Controller
{
    public function index()
    {
        $services = SubService::all();
        $allservice = Service::all();
        return view('admin.all_subservices',compact('services','allservice'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'services' => 'required|exists:services,id',
            'services_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('services/images'), $imageName);
            $imagePath = 'services/images/' . $imageName;
        }
        $subService = new SubService();
        $subService->services_id = $validatedData['services'];
        $subService->name = $validatedData['services_name'];
        $subService->description = $validatedData['description'];
        $subService->image = $imagePath??'';
        $subService->save();
        return redirect()->route('sub-service')->with('success', 'Sub service created successfully.');
    }

    public function create()
    {
        $services = Service::all();
        return view('admin.add_subservices',compact('services'));
    }

    public function edit($id){
        $service = SubService::find($id);
        // dd($id);
        return response()->json($service);
    }
    
    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'services' => 'required|exists:services,id',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $subService = SubService::findOrFail($request->service_id);
        $subService->name = $request->input('name');
        $subService->description = $request->input('description');
        $subService->services_id = $request->input('services');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('services/images'), $imageName);
            $imagePath = 'services/images/' . $imageName;
            if ($subService->image) {
                if (file_exists(public_path($subService->image))) {
                    unlink(public_path($subService->image));
                }
            }
            $subService->image = $imagePath;
        }
        $subService->save();
        return redirect()->back()->with('success', 'SubService updated successfully.');
    }
    public function delete($id)
    {
        $service = SubService::findOrFail($id);
        // dd($service);
        $service->delete();
        return redirect()->back()->with('success', 'Service deleted successfully');
    }

}

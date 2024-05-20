<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('admin.all_services', compact('services'));
    }
    public function create()
    {
        return view('admin.create_services');
    }
    public function service_store(Request $request)
    {
        $validatedData = $request->validate([
            'services_name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $service = new Service();
        $service->services_name = $validatedData['services_name'];
        $service->description = $validatedData['description'];

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/services'), $imageName);
            $service->image = 'images/services/' . $imageName;
        }

        $service->save();
        return redirect()->route('service')->with('success', 'Service created successfully!');
    }

    public function filter(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $start = $request->start;
        $end = $request->end;
        $services = Service::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.all_services', compact('services', 'start', 'end'));
    }

    public function edit($id)
    {   
        $Did = decrypt($id);
        $service = Service::find($Did);
        return view('admin.create_services', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validatedData = $request->validate([
            'services_name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // dd($request->all());
        $service->update([
            'services_name' => $validatedData['services_name'],
            'description' => $validatedData['description'],
            'status' => $request->input('status') ?? 1,
        ]);
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($service->image) {
                $oldImagePath = public_path($service->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/services'), $imageName);
            $service->image = 'images/services/' . $imageName;

            $service->save();
        }

        return redirect()->route('service')->with('success', 'Service updated successfully!');
    }
    public function destroy($id)
    {
        $service = Service::find($id);
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $service->delete();
        return response()->json(['status' => true]);
    }
}

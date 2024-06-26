<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    public function index()
    {
        $servicesUrl = "https://bmdublog.com/solutionkey/public/";
        $services = Service::where('status', true)->latest()->get();
        if ($services->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'No Services found.'], Response::HTTP_NOT_FOUND);
        }
        $services->each(function ($service) use ($servicesUrl) {
            $service->image = $servicesUrl . $service->image;
        });
        return response()->json(['status' => true, 'services' => $services], Response::HTTP_OK);
    }
}

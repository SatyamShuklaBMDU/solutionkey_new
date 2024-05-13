<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ManagerBlog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'vendor_id' => 'required|exists:vendors,id',
                'blog_media' => 'required|file',
                'blog_media.*' => 'mimetypes:image/jpeg,image/png,video/mp4',
                'content' => 'required|string',
            ]);
            if ($request->hasFile('blog_media')) {
                $file = $request->file('blog_media');
                $fileName = $file->getClientOriginalName();
                // $fileSize = $file->getSize();
                // $maxSize = $file->getMimeType() == 'video/mp4' ? 10 * 1024 : 2 * 1024;
                // dd( $fileSize);
                // if ($fileSize > $maxSize) {
                //     return response()->json(['error' => 'File size exceeds the allowed limit'], 422);
                // }
                $file->move(public_path('blog_media'), $fileName);
                $mediaPath = 'blog_media/' . $fileName;
            }
            $blog = ManagerBlog::create([
                'vendor_id' => $request->vendor_id,
                'blog_media' => $mediaPath ?? null,
                'content' => $request->content,
                'status' => '0',
            ]);
            return response()->json(['message' => 'Blog registered successfully', 'blog' => $blog], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to register blog'], 500);
        }
    }
}

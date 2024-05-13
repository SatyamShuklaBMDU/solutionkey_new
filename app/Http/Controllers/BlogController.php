<?php

namespace App\Http\Controllers;

use App\Models\ManagerBlog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function pending()
    {
        $blog = ManagerBlog::where('status','0')->orWhere('status','-1')->get();
        return view('admin.blog_pending',compact('blog'));
    }
    public function approved()
    {
        $blog = ManagerBlog::where('status','1')->get();
        return view('admin.blog_approved',compact('blog'));
    }
    public function changeAccountStatus(Request $request)
    {
        $customerId = $request->input('blog_id');
        $newStatus = $request->input('new_status');
        $remark = $request->input('remark');
        // dd($request->all());
        $blog = ManagerBlog::find($customerId);
        if (!$blog) {
            return response()->json(['success' => false, 'message' => 'Blog not found'], 404);
        }
        $blog->status = $newStatus;
        if ($newStatus == -1) {
            $blog->status_remark = $remark;
        }else {
            $blog->status_remark = null;
        }
        $blog->save();
        return response()->json(['success' => true, 'message' => 'Account status updated successfully']);
    }
    public function Pendingfilter(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $start = $request->start;
        $end = $request->end;
        $blog = ManagerBlog::where('status','-1')
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.blog_pending', compact('blog', 'start', 'end'));
    }
    public function Approvefilter(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $start = $request->start;
        $end = $request->end;
        $blog = ManagerBlog::where('status','1')
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.blog_approved', compact('blog', 'start', 'end'));
    }
}

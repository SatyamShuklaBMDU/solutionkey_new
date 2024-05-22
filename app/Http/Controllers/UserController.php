<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function adduser()
    {
        $users = User::all();
        return view('admin.users', compact('users'));

    }
    public function alluser()
    {
        $users = User::where('role','!=','admin')->get();
        return view('admin.all_users', compact('users'));

    }
    public function user_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'password' => 'required|min:6',
            'permission' => 'required',
        ], [
            'email.unique' => 'The email address is already in use.',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->permission = json_encode($request->permission);
        $user->save();
        return redirect()->route('all-users')->with('success', 'Data Added Successfully');
    }
    public function filter(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $start = $request->start;
        $end = $request->end;
        $users = User::where('role','!=','admin')
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.all_users', compact('users', 'start', 'end'));
    }
    public function editUser(Request $request)
    {
        $userData = User::where('id', $request->id)->first();
        return $userData;
    }
    public function updateUser(Request $request)
    {
        $update = [
            'name' => $request->name,
            'role' => $request->role,
            'permission' => json_encode($request->permission),
        ];
        // dd($update);
        $userDataUpdate = User::where('id', $request->userId)->update($update);
        $updatedUserData = User::where('id', $request->userId)->first();
        return back()->with('success','Data Updated Successfully');
    }
    
    public function destroy($id)
    {
        try {
            $customer = User::findOrFail($id);
            $customer->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}

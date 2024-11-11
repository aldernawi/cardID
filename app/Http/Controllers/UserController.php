<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'user_type' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => $request->user_type,
            'password' => Hash::make($request->password),
        ]);
        return response()->json(['success' => 'تم اضافة المستخدم بنجاح.']);
    }

   
     public function edit($id)
    {
        $user = User::find($id)->first();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'user_type' => 'required|string|max:255',
            'password' => 'nullable|min:8|confirmed', // You can adjust the validation as needed
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = $request->user_type;
        
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('users')->with('success', 'تم تحديث المستخدم بنجاح.');
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users')->with('success', 'تم حذف المستخدم بنجاح.');
    }

}

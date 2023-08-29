<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->view('lgs.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('lgs.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [

            'name' => 'required|string|min:3|max:50',
            'email' => 'required|string',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'max:50'
            ],
            'password_confirmation' => 'required|string|min:8|max:50',
            'typeUser' => ['required', 'in:admin,user'],
            'gender' => ['required', 'in:male,female'],
            'image' => 'required|image|mimes:png,jpg,jpeg|max:5000',
        ]);

        if (!$validator->fails()) {
            $user = new User();
            $user->password = Hash::make($request->input('password'));
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->role = $request->input('typeUser');
            $user->gender = $request->input('gender');
            $user->phone = $request->input('phone');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_' . rand(1, 1000000) . '.' . $file->getClientOriginalExtension();
                $image = $file->storePubliclyAs('users', $imageName, ['disk' => 'public']);
                $user->image = $image;
            }

            $isSaved = $user->save();
            return response()->json([
                'message' => $isSaved ? 'Create User Successfully' : 'Create User Failed'
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return response()->view('lgs.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = validator($request->all(), [

            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email:rfc',
            'phone' => 'required|string|min:10',
            'gender' => 'required|string|in:male,female',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:5000',
        ]);

        if (!$validator->fails()) {
            $user->name = $request->input('name');
            $user->phone = $request->input('phone');
            $user->email = $request->input('email');
            $user->gender = $request->input('gender');

            if ($request->hasFile('image')) {
                Storage::disk('public')->delete('' . $user->image);
                $file = $request->file('image');
                $imageName = time() . '_' . rand(1, 1000000) . '.' . $file->getClientOriginalExtension();
                $newimage = $file->storePubliclyAs('users', $imageName, ['disk' => 'public']);
                $user->image = $newimage;
            }

            $isSaved = $user->save();
            return response()->json([
                'message' => $isSaved ? 'Create User Successfully' : 'Create User Failed'
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function toggleRole(User $user)
    {
        $user->role = $user->role == 'admin' ? 'user' : 'admin';
        $isSaved = $user->save();
        return response()->json([
            'message' => $isSaved ? 'Role Changed successfully!' : 'Failed to change role, Please try again.',
            'role' => $user->role,
        ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function index(Request $request) // Authentications
    {
        $user= User::where('email', $request->email)->first();
        // print_r($data);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function store(Request $request)
    {
        $user= new User([
            'name' =>$request->get('name'),
            'email' =>$request->get('email'),
            'password' =>$request->get('password'),
            'role' =>$request->get('role'),
        ]);
        $user->save();
    }

    public function show($id =null)
    {
        // Find certain admin with certain id

        return $id? User::find($id) : admin::all();
    }

    public function showbyEmail($email)
    {
        // Find certain user with certain email
        $User = User::where('email',$email)->get();
        return $User;
    }

    public function update(Request $request, $id)
    {
//        $this->validate($request,
//            ['name' => 'required',
//                'email' => 'required',
//                'password' => 'required',
//                'role' => 'required'
//            ]);
        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = $request->get('password');
        $user->save();
    }

    public function changePassword(Request $request,$id){
        $user = User::find($id);
        $user->password = $request->get('password');
        $user->save();
    }

    public function destroy($id)
    {
        $user= User::find($id);
        $user->delete();
        ////////////////////// RETURN TO ROUTING Page access DONE
    }

}

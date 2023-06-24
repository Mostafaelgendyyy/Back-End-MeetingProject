<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
        $this->validate($request,
            ['name' => 'required',
                'email' => 'required',
                'password' => 'required',
                'role' => 'required'
            ]);
        $user = User::find($id);
        $user->name = $request . get('name');
        $user->email = $request . get('email');
        $user->password = $request . get('password');
        $user->username = $request . get('role');
        $user->save();
    }

    public function destroy($id)
    {
        $user= User::find($id);
        $user->delete();
        return 'Admin Deleted';
        ////////////////////// RETURN TO ROUTING Page access DONE

    }

}

<?php

namespace App\Http\Controllers;

use App\Models\doctor;
use App\Models\User;
use Illuminate\Http\Request;

class doctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()

    {
//        $this->middleware('auth');
//        $this->middleware('role:ROLE_DOCTOR');
    }
    public function index()
    {
        //
        return view('doctor');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $this->validate($request,
//            ['adminid'=>'required',
//                'name' =>'required',
//                'email' =>'required',
//                'password' =>'required',
//                'department' =>'required',
//                'isinitiator'=>'required'
//            ]);
        $Doctor = new User([
            'adminstration' =>$request->get('adminstration'),
            'email' =>$request->get('email'),
            'password' =>$request->get('password'),
            'role' =>'2',
            'name' =>$request->get('name')]);
        $Doctor->save();
        ///////Return ROUTING SUCCESSSS
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Doctor= User::find($id);
        dd($Doctor);

    }
    public function showbyEmail($EMail)
    {
        $Doctor= User::where('email',$EMail);
        dd($Doctor);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        $this->validate($request,
//            ['adminid'=>'required',
//                'name' =>'required',
//                'email' =>'required',
//                'password' =>'required',
//                'department' =>'required',
//                'isinitiator'=>'required'
//            ]);
        $Doctor = User::find($id);
        if ($Doctor->role=="2")
        {
            $Doctor->name =$request->get('name');
            $Doctor->email =$request->get('email');
            $Doctor->password =$request->get('password');
            $Doctor->adminstration =$request->get('adminstration');
            $Doctor->save();
        }
        // ROUTINGGGGGGGGGG
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Doctor = User:: find($id);
        if ($Doctor->role=="2")
        {
            $Doctor->delete();
        }

        // ROUTING
    }


}

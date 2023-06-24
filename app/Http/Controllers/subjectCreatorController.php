<?php

namespace App\Http\Controllers;

use App\Models\subjectCreator;
use Illuminate\Http\Request;

class subjectCreatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
        $this->validate($request,
            ['adminid' =>'required',
                'adminstration' =>'required',
                'name' =>'required',
                'email' =>'required',
                'password' =>'required',
                'username' =>'required'
            ]);
        $subjectCreator= new subjectCreator(['adminid' =>$request->get('adminid'),
            'adminstration' =>$request->get('adminstration'),
            'name' =>$request->get('name'),
            'email' =>$request->get('email'),
            'password' =>$request->get('password'),
            'username' =>$request->get('username')]);
        $subjectCreator->save(); # saving Data to Database
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $subjectCreator=subjectCreator::find($id);
        dd($subjectCreator);
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
        //
        $this->validate($request,
            ['adminid' =>'required',
                'adminstration' =>'required',
                'name' =>'required',
                'email' =>'required',
                'password' =>'required',
                'username' =>'required'
            ]);
        $subjectCreator= subjectCreator::find($id);
        $subjectCreator->adminid =$request->get('adminid');
        $subjectCreator->adminstration =$request->get('adminstration');
        $subjectCreator->email =$request->get('email');
        $subjectCreator->password =$request->get('password');
        $subjectCreator->username =$request->get('username');
        $subjectCreator->name =$request->get('name');

        $subjectCreator->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $subjectCreator=subjectCreator::find($id);
        $subjectCreator->delete();
    }
}

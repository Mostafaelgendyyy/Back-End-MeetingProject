<?php

namespace App\Http\Controllers;

use App\Models\subject;
use Illuminate\Http\Request;

class subjectController extends Controller
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
//        $this->validate([
//            'creatorid'=> 'required',
//            'controllerid'=> 'required',
//            'description'=> 'required',
//            'finaldesicion'=> 'required',
//            'iscompleted'=> 'required',
//            'from'=> 'required'
//        ]);
        $subject= new subject([
            'controllerid' => $request->get('controllerid'),
            'description' => $request->get('description'),
            'finaldecision' => $request->get('finaldecision'),
            'iscompleted' => $request->get('iscompleted'),
            'from' => $request->get('from')
        ]);
        $subject->save();

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
        $subject=subject::find($id);
        dd($subject);
    }

    public function showByDesc($Desc)
    {
        //
        $subject=subject::where('description',$Desc);
        dd($subject);
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
//        $this->validate([
//            'creatorid'=> 'required',
//            'controllerid'=> 'required',
//            'description'=> 'required',
//            'finaldesicion'=> 'required',
//            'iscompleted'=> 'required',
//            'from'=> 'required'
//        ]);
        $subject= subject::find($id);
        $subject->creatorid = $request->get('creatorid');
        $subject->controllerid= $request->get('controllerid');
        $subject->description= $request->get('description');
        $subject->finaldesicion= $request->get('finaldesicion');
        $subject->iscompleted= $request->get('iscompleted');
        $subject->from= $request->get('from');
        $subject->save();
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
        $subject=subject::find($id);
        $subject->delete();
    }

    public function archive($id)
    {
        subject::find($id)->update(["iscompleted" => "1"]);
    }
}

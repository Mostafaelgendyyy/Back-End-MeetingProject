<?php

namespace App\Http\Controllers;

use App\Models\MeetingSubjects;
use App\Models\subject;
use Illuminate\Http\Request;

class MeetingSubjectsController extends Controller
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
        $MS= new MeetingSubjects([
            'meetingid' => $request->get('meetingid'),
            'subjectid' => $request->get('subjectid'),
            'decision'=>$request->get('decision'),
        ]);
        $MS->save();
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
        $MS= MeetingSubjects::find($id);
        return $MS;
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
        $MS= MeetingSubjects::find($id);
        $MS->delete();
    }

    public function getSubjectsofMeeting($meetingid){
        $subjectsIDS = MeetingSubjects::select('subjectid')->where('meetingid',$meetingid)->get();

        $subjectsData= subject::find($subjectsIDS);
        return $subjectsData;
    }
}

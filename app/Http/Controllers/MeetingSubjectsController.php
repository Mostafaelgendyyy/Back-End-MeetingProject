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
    public function update(Request $request,$id)
    {
        //
        $MS=MeetingSubjects::find($id);
//        $MS= MeetingSubjects::where([
//            ['subjectid',$request->get('subjectid')],
//            ['meetingid',$request->get('meetingid')]
//        ])->get();

        $MS->decision = $request->get('decision');
        $MS->save();
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
        $subjects= array();
        foreach ($subjectsIDS as $key => $value){
            array_push($subjects,subject::find($value['subjectid']));
        }
        return $subjects;
    }

    public function getMeetings($subjectid){
        $meetingid = MeetingSubjects::select('meetingid')->where('subjectid',$subjectid)->get();
        $meetings= array();
        foreach ($meetingid as $key => $value){
            array_push($subjects,subject::find($value['meetingid']));
        }
        return $meetings;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\InvitationNotificationInvited;
use App\Models\InvitationNotifications;
use App\Models\Invited;
use App\Models\meeting;
use App\Models\MeetingSubjects;
use App\Models\subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class meetingController extends Controller
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
//            'initiatorid'=> 'required',
//            'location'=> 'required',
//            'date'=> 'required',
//            'topic'=> 'required'
//        ]);


        $Meeting = new meeting([
            'initiatorid' => $request->get('initiatorid'),
            'location'=> $request->get('location'),
            'date'=> $request->get('date'),
            'topic'=> $request->get('topic'),
            'meetingtype'=> $request->get('meetingtype'),
            'islast'=>'1'
        ]);
        $Meeting->save();

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
        return meeting::find($id);

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
//            'initiatorid'=> 'required',
//            'location'=> 'required',
//            'date'=> 'required',
//            'topic'=> 'required'
//        ]);
        $Meeting = meeting::find($id);

        $Meeting->initiatorid = $request->get('initiatorid');
        $Meeting->location = $request->get('location');
        $Meeting->date = $request->get('date');
        $Meeting->meetingtype = $request->get('meetingtype');
        $Meeting->save();
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
        $Meeting=meeting::find($id);
        $Meeting->delete();
    }

    public function updatePrev($id){
        meeting::where([['initiatorid',$id],['islast',-1]])->update(['islast'=>'0']);
    }
    public function updatelastofInitiator($id){

        meeting::where([['initiatorid',$id],['islast',1]])->update(['islast'=>'-1']);
    }
    public function getlastofInitiator($id){

        $filter = meeting::where([['initiatorid',$id],['islast',1]])->get();
        return $filter;
    }

    public function getUpcomingMeetings(){
        $NowDT = Carbon::now()->toDateString();
        return meeting::where('date', '>', $NowDT)->get();
    }

    public function getPrevious($id){
        return meeting::where([
            ['initiatorid',$id],
            ['islast',-1]
        ])->get();
    }

    public function isLast($id){
        $me= meeting::find($id);
        if ($me->islast==1){
            return true;
        }
        return false;
    }

    public function isPrevious($id){
        $me= meeting::find($id);
        if ($me->islast==-1){
            return true;
        }
        return false;
    }

    public function isDone($id){
        $me= meeting::find($id);
        $NowDT = Carbon::now()->toDateString();
        if ($me->date > $NowDT){
            return true;
        }
        return false;
    }
    public function showInitiator($Id){
        return meeting::where(['meetingid',$Id])->select('initiatorid');
    }

    public function RetreivedataforLast($initiatorid){
        $last = meeting::select('meetingid')->where([
            ['initiatorid',$initiatorid],
            ['islast',1]
        ])->get();
        foreach($last as $key=>$value)
        {
            $subjects = MeetingSubjects::where('meetingid',$value['meetingid'])->get();
            return $subjects;
        }
    }

    public function addEnded($id)
    {
        $NowDT = Carbon::now()->toDateString();
        $meeting = meeting::find($id);
        $meeting->endedtime= $NowDT;
        $meeting->save();
    }



    public function FinalizeMeeting(Request $request)
    {
        $data= $request->all();
        $MS= new MeetingSubjectsController();
        $meetingid= 0;
        foreach($data as $key => $value){
            $newRequest= new Request();
            $meetingid=$value['meetingid'];
            $newRequest->merge(['subjectid'=>strval($value['subjectid']),'meetingid'=>strval($value['meetingid'])]);
            $MS->update($newRequest,$value['id']);
        }
        $this->addEnded($meetingid);
        $initiatorid = meeting::select('initiatorid')->find($meetingid);
        $this->updatePrev($initiatorid);
        $this->updatelastofInitiator($initiatorid);
    }



    /************* PRevious ********/

    public function DataPreviousforPDF ($initiatorid){
        $last = meeting::select('meetingid')->where([
            ['initiatorid',$initiatorid],
            ['islast',-1]
        ])->get();

        foreach($last as $key=>$value)
        {
            $subjects = MeetingSubjects::where('meetingid',$value['meetingid'])->get();
            $subjectData=array();
            foreach($subjects as $k =>$v)
            {
                array_push($subjectData, subject::find($v['subjectid']));
            }
            $attendee= InvitationNotifications::where([
                ['meetingid',$value['meetingid']],
                ['fromoutside',0],
                ['status',1]
            ])->get();
            $attendeeData=array();
            foreach($attendee as $k =>$v)
            {
                array_push($attendeeData, User::find($v['doctorid']));
            }
            $absence= InvitationNotifications::where([
                ['meetingid',$value['meetingid']],
                ['status',0]
            ])->get();
            $absenceData=array();
            foreach($absence as $k =>$v)
            {
                array_push($absenceData, User::find($v['doctorid']));
            }
            $InvitedUsers = InvitationNotifications::where([
                ['meetingid',$value['meetingid']],
                ['fromoutside',1]
            ])->get();
            $Invited= InvitationNotificationInvited::where([
                ['meetingid',$value['meetingid']],
            ])->get();
            $invitedData=array();
            foreach($InvitedUsers as $k =>$v)
            {
                array_push($invitedData, User::find($v['doctorid']));
            }

            foreach($Invited as $k =>$v)
            {
                array_push($invitedData, Invited::find($v['invitedid']));
            }
            return [
                'subjects'=>$subjects,
                'subjectsData'=>$subjectData,
                'attendee'=>$attendee,
                'attendeeData'=>$attendeeData,
                'absence'=>$absence,
                'absenceData'=>$absenceData,
                'invited'=>[$InvitedUsers,$Invited],
                'invitedData'=>$invitedData
            ];
        }
    }
}

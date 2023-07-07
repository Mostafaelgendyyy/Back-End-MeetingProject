<?php

namespace App\Http\Controllers;

use App\Models\containerSubjects;
use App\Models\meeting;
use App\Models\MeetingSubjects;
use App\Models\subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
    //
//        $this->validate([
//            'creatorid'=> 'required',
//            'controllerid'=> 'required',
//            'description'=> 'required',
//            'finaldesicion'=> 'required',
//            'iscompleted'=> 'required',
//            'from'=> 'required'
//        ]);


    public function store(Request $request)
    {
        $creatorrole = User::select('role')->find($request->get('userid'));
        if ($creatorrole['role']==3)
        {
            $lastmeeting = meeting::where('initiatorid',$request->get('userid'))->get()->last();
            $NowDT = Carbon::now()->toDateString();
            if ($NowDT < $lastmeeting['date']){
                $MS= new MeetingSubjectsController();
                $subject= new subject([
                    'userid' => $request->get('userid'),
                    'description' => $request->get('description'),
                    'subjecttype'=> $request->get('subjecttype'),
                    'iscompleted' => 1,
                    'attachmentlink'=>$request->get('attachmentlink')
                ]);
//            return $lastmeeting['meetingid'];
                $subject->save();
                $subid= subject::select('subjectid')->where('userid',$request->get('userid'))->get()->last();
                $requestforSubject= new Request();
                $requestforSubject->merge(['meetingid'=>strval($lastmeeting['meetingid']),'subjectid'=>strval($subid['subjectid'])]);
                $MS->store($requestforSubject);
            }
            else{
                $subject= new subject([
                    'userid' => $request->get('userid'),
                    'description' => $request->get('description'),
                    'subjecttype'=> $request->get('subjecttype'),
                    'iscompleted' => 0,
                    'attachmentlink'=>$request->get('attachmentlink')
                ]);
                $subject->save();
            }
        }
        else{
            $subject= new subject([
                'userid' => $request->get('userid'),
                'description' => $request->get('description'),
                'subjecttype'=> $request->get('subjecttype'),
                'iscompleted' => 0,
                'attachmentlink'=>$request->get('attachmentlink')
            ]);
            $subject->save();
        }
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
        return $subject;
    }

    public function showByDesc($Desc)
    {
        //
        $subject = subject::where('description', 'LIKE', '%'.$Desc.'%')
            ->get();
        return $subject;
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
        $subject= subject::find($id);
        $subject->controllerid= $request->get('controllerid');
        $subject->description= $request->get('description');
        $subject->finaldesicion= $request->get('finaldesicion');
        $subject->iscompleted= $request->get('iscompleted');
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

    public function getSubjects($controllerid){
        $controllerAdminstration = User::select('adminstration')->find($controllerid);

        $subjects= subject::select('subjectid','userid')
            ->where('iscompleted',0)->get();
        $IDS = array();
        foreach ($subjects as $key=>$value){
            $users= User::select('adminstration')->find($value['userid']);

            //return $controllerAdminstration ;

            if ($users['adminstration'] == $controllerAdminstration['adminstration'])
            {
                array_push($IDS,$value['subjectid']);
            }

        }
        return subject::find($IDS);
    }

    //public function getArchived()

    public function getAttachments($id){
        $subject= subject::find($id);
        $subjectattach=$subject::select('attachment-link')->get();
        return $subjectattach;
    }

    public function redirectSubject(Request $request,$id){
        $subject=subject::find($id);
        $deptfrom = $subject->to;
        $subject->from=$deptfrom;
        $subject->to= $request->get('to');
        $subject->save();
    }


    public function showArchive($initiatorid){

        $intiatorAdminstration = User::select('adminstration')->find($initiatorid);

        $subjects= subject::select('subjectid','userid')
            ->where('iscompleted',1)->get();
        $IDS = array();
        foreach ($subjects as $key=>$value){
            $users= User::select('adminstration')->find($value['userid']);

            //return $controllerAdminstration ;

            if ($users['adminstration'] == $intiatorAdminstration['adminstration'])
            {
                array_push($IDS,$value['subjectid']);
            }

        }

        $meetingIDs= meeting::select('meetingid')->where('meetingtype','مجلس كلية')->get();


        foreach($meetingIDs as $key=>$value){
            $subjects= MeetingSubjects::where('meetingid',$value['meetingid'])->get();
            foreach($subjects as $k =>$v)
            {
                array_push($IDS,$v['subjectid']);

            }

        }

        return MeetingSubjects::whereIn('subjectid',$IDS)->get();



    }


}

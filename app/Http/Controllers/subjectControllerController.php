<?php

namespace App\Http\Controllers;

use App\Models\meeting;
use App\Models\MeetingSubjects;
use App\Models\subject;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\subjectController;

class subjectControllerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('SubjectController');
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
//            [
//                'name' =>'required',
//                'email' =>'required',
//                'password' =>'required',
//                'adminstration' =>'required',
//            ]);
        $subjectController= new User([
            'adminstrationid' =>$request->get('adminstrationid'),
            'email' =>$request->get('email'),
            'password' =>$request->get('password'),
            'role' =>'0',
            'name' =>$request->get('name')]);
        $subjectController->save(); # saving Data to Database
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
        $subjectController=subjectController::find($id);
        dd($subjectController);
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
                'email' =>'required',
                'password' =>'required',
                'username' =>'required',
                'name' =>'required'
            ]);
        $subjectController= subjectController::find($id);
        $subjectController->adminid =$request->get('adminid');
        $subjectController->adminstration =$request->get('adminstration');
        $subjectController->email =$request->get('email');
        $subjectController->password =$request->get('password');
        $subjectController->username =$request->get('username');
        $subjectController->name =$request->get('name');

        $subjectController->save();
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
        $subjectController=User::find($id);
        if($subjectController->role=='0'){
            $subjectController->delete();
        }
        else {
            return 'cannot delete this User';
        }
    }
    ///////////////////////////////////     CLASS DIAGRAM COntroller FUNCTIONALITYYY

    public function SearchSubject(String $desc){
        $SC= new subjectController();
        return $SC->showByDesc($desc);
    }



    public function AddSubjecttoMeeting(Request $request){
        $CS= new MeetingSubjectsController();
        $data= $request->all();
        foreach ($data as $Key=>$value){
            $CS->store($value);
        }
    }

    public function RemoveSubjectFromMeeting($id){
        $CS= new MeetingSubjectsController();
        $CS->destroy($id);
    }

    public function getSubjects($id){
        $controller= new subjectController();
        return $controller->getSubjects($id);
    }

    public function getPrevPDF($id){
        $lastsubjectWritten = subject::where([
            ['userid',$id],
            ['iscompleted',1]
        ])->get()->last();

        $meetingid = MeetingSubjects::where('subjectid',$lastsubjectWritten->subjectid)->get();
        $MIC= new MeetingController();
        foreach ($meetingid as $k=> $v)
        {
            $initiator = meeting::select('initiatorid')->find($v['meetingid']);
            return $MIC->DataPreviousforPDF($initiator['initiatorid']);
        }

    }
}


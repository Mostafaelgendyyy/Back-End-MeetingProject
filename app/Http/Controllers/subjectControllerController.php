<?php

namespace App\Http\Controllers;

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
            'adminstration' =>$request->get('adminstration'),
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
        $SC->showByDesc($desc);
    }

    public function ArchiveSubject($id){

        $SC = new \App\Http\Controllers\subjectController();
        $SC->archive($id);
    }

    public function AddSubjecttoContainer(Request $request){
        $CS= new containerSubjectController();
        $CS->store($request);
    }

    public function RemoveSubjectFromContainer($id){
        $CS= new containerSubjectController();
        $CS->destroy($id);
    }

    public function getSubjects($id){
        $SC = User::find($id);
        $controller= new subjectController();
        return $controller->getSubjectsforController($SC->adminstration);
    }
}


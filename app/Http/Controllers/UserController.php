<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
      {
          $this->middleware('admin');
      }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $users=User::filter(request(['search']))->paginate(10)->withQueryString();
      $count = User::where('is_admin',false)->count();
      $schools=School::all();
      return view('admin.user.index',compact('users','count','schools'));
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
      $this->authorize('admin');
      $this->validate($request, [
        'name' => 'required', 'string', 'max:255',
        'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
        'password' => 'required', 'string', 'min:8', 'confirmed',
        'student_id' =>  'nullable|sometimes|unique:users',
        'school_id' =>  'nullable|sometimes',
        'is_admin' =>  'boolean'
      ]);
      if(!$request->student_id){
        $request->student_id = null;
      }elseif(!$request->school_id){
        $request->school_id= null;
      }
      if(!$request->is_admin){
        $request->is_admin= 0;
      }
      User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'student_id' => $request->student_id,
        'school_id' => $request->school_id,
        'is_admin' => $request->is_admin,
      ]);
      return redirect()->route('user.index');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,User $user)
    {
      $this->authorize('admin');
      $this->validate($request, [
        'name' => 'required', 'string', 'max:255',
        'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
        'student_id' =>  'nullable|sometimes|unique:users,student_id,'.$user->id,
        'school_id' =>  'nullable|sometimes',
        'is_admin' =>  'boolean'
      ]);
      if(!$request->student_id){
        $request->student_id = null;
      }elseif(!$request->school_id){
        $request->school_id= null;
      }
      if(!$request->is_admin){
        $request->is_admin= 0;
      }
      $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'student_id' => $request->student_id,
        'school_id' => $request->school_id,
        'is_admin' => $request->is_admin,
      ]);
      return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
      $this->authorize('admin');
      foreach ( $user->theses as $thesis) {
        Storage::disk('public')->delete('documents/'.$thesis->document);
        $thesis->delete();
      }
      Storage::disk('public')->delete('pictures/'.$user->picture);
      $user->delete();
      return redirect()->route('user.index')->with('success','Task Deleted Successfully');
    }
}

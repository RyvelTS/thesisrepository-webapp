<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolController extends Controller
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
      $schools=School::filter(request(['search']))->paginate(5)->withQueryString();
      $count = School::all()->count();
      return view('admin.school.index',compact('schools','count'));
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'name'    => 'required',
      ]);
      $this->authorize('create', School::class);
      School::create([
        'name' => $request->name,
      ]);
      
      return redirect()->route('school.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function show(School $school)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function edit(School $school)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, School $school)
    {
      $this->authorize('update',$school);
      $this->validate($request, [
        'name'    => 'required',
      ]);
      $school->update([
        'name'=>$request->name,
      ]);
      return redirect()->route('school.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school)
    {
      $this->authorize('delete',$school);
      foreach ($school->users as $user) {
        foreach ( $user->theses as $thesis) {
          Storage::disk('public')->delete('documents/'.$thesis->document);
          $thesis->delete();
        }
        Storage::disk('public')->delete('pictures/'.$user->picture);
        $user->delete();
      }
      $school->delete();
      return redirect()->route('school.index')->with('success','Task Deleted Successfully');
    }
}

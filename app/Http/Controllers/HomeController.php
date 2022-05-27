<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Thesis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    $count = (object)array(
      'thesis' => Thesis::all()->count(), 
      'user' => User::where('is_admin',false)->count(),
      'school' => School::all()->count()
    );
    $recent_thesis = Thesis::where('user_id',Auth::user()->id)->orderBy('updated_at','DESC')->first();
    return view('home',compact('recent_thesis','count'));
  }
  public function show()
  {
    $schools=School::all();
    return view('user.profile.show',compact('schools'));
  }
  public function update(Request $request)
  {
    $user = Auth::user();
    $this->validate($request, [
      'student_id' =>  'required|sometimes|unique:users,student_id,'.$user->id,
      'picture' => 'image|file|max:2048'
    ]);
    if ($request->hasFile('picture')) {
      if ($request->old_picture){
        Storage::disk('public')->delete('pictures/'.$request->old_picture);
      }
	    $filename = $request->picture->getClientOriginalName();
      $request->picture->storeAs('pictures',$filename,'public');
      $user->update(['picture'=>$filename]);
	  }
    $user->update([
      'student_id'=>$request->student_id,
      'school_id'=>$request->school_id,
    ]);
    return redirect()->route('profile');
  }
  public function storePicture(Request $request)
  {
    $user = Auth::user();
    $user->student_id= $request->student_id;
    $user->school_id= $request->school_id;
    $user->save();
    return redirect()->route('profile');
  }
}

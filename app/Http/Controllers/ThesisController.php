<?php

namespace App\Http\Controllers;

use App\Models\Thesis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ThesisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
      $theses=Thesis::latest()->filter(request(['search','user','school']))->paginate(7)->withQueryString();
      return view('user.search.index', compact('theses'));
    }

    public function indexMyThesis()
    {
      $theses = Thesis::where('user_id',Auth::user()->id)->orderBy('id','DESC')->paginate(5);
      return view('user.thesis.index', compact('theses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('user.thesis.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create', Thesis::class);
      $this->validate($request, [
        'title'    => 'required',
        'document' => 'mimes:pdf|max:10000',
        'supervisor_name'    => 'required'
      ]);
      if ($request->hasFile('document')) {
        $filename = $request->document->getClientOriginalName();
        $request->document->storeAs('documents',$filename,'public');
        $thesis = Thesis::create([
          'user_id'=>Auth::user()->id,
          'title'=> $request->title,
          'supervisor_name'=>$request->supervisor_name,
          'document'=>$filename,
        ]);
      } else{
        $thesis = Thesis::create([
          'user_id'=>Auth::user()->id,
          'title'=> $request->title,
          'supervisor_name'=>$request->supervisor_name
        ]);
      }
      
      return view('user.thesis.show', compact('thesis'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Thesis  $thesis
     * @return \Illuminate\Http\Response
     */
    public function show($thesis_id)
    {
      $thesis = Thesis::findOrFail($thesis_id);
      return view('user.thesis.show', compact('thesis'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Thesis  $thesis
     * @return \Illuminate\Http\Response
     * 
     */
    public function edit($thesis_id)
    {
      
      $thesis = Thesis::findOrFail($thesis_id);
      $this->authorize('update', $thesis);
      return view('user.thesis.edit', compact('thesis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Thesis  $thesis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $thesis_id)
    {
      $thesis = Thesis::find($request->thesis_id);
      $this->authorize('update', $thesis);
      if($request->old_document){
        Storage::disk('public')->delete('documents/'.$request->old_document);
        $thesis->update([
          'document'=>null
        ]);
      }else{
        $this->validate($request, [
          'title'    => 'required',
          'document' => 'mimes:pdf|max:10000',
          'supervisor_name'    => 'required'
        ]);
        if ($request->hasFile('document')) {
          $filename = $request->document->getClientOriginalName();
          $request->document->storeAs('documents',$filename,'public');
          $thesis->update(['document'=>$filename]);
        }
        $thesis->update([
          'title'=>$request->title,
          'supervisor_name'=>$request->supervisor_name,
        ]);
      }
      return redirect()->route('thesis_show',[$thesis_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Thesis  $thesis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $thesis = Thesis::find($request->thesis_id);
      $this->authorize('delete', $thesis);
      Storage::disk('public')->delete('documents/'.$thesis->document);
      $thesis->delete();
      if ( Gate::allows('admin')) {
        return redirect()->route('thesis_search');
      }
      return redirect()->route('user_thesis_index');
    }
}

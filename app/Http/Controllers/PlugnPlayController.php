<?php

namespace App\Http\Controllers;

use App\PlugnPlay;
use Illuminate\Http\Request;

class PlugnPlayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkSetting=PlugnPlay::where('id',1)->count();
        if($checkSetting==1)
        {
            $edit=PlugnPlay::where('id',1)->first();
            return view('admin.apps.pages.plug-and-play.index',compact('edit'));
        }
        else
        {
            return view('admin.apps.pages.plug-and-play.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request,
            [
                'title'=>'required',
                'image'=>'required',
            ]
        );

        $Feature=new PlugnPlay();
        $Feature->title=$request->title;
        $Feature->sub_title=$request->sub_title;
        $Feature->save();
        
        
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Plugn and Play Saved Successfully.');
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PlugnPlay  $plugnPlay
     * @return \Illuminate\Http\Response
     */
    public function show(PlugnPlay $plugnPlay,$id=0)
    {
        $edit=PlugnPlay::find($id);
        $dataTable = PlugnPlay::all();
        return view('admin.apps.pages.plug-and-play.index',compact('edit','dataTable'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PlugnPlay  $plugnPlay
     * @return \Illuminate\Http\Response
     */
    public function edit(PlugnPlay $plugnPlay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PlugnPlay  $plugnPlay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlugnPlay $plugnPlay,$id=0)
    {
        $this->validate($request,
            [
                'title'=>'required',
            ]
        );

        $Feature=PlugnPlay::find($id);
        $Feature->title=$request->title;
        $Feature->sub_title=$request->sub_title;
        $Feature->save();
        return redirect ('admin-site/plug-and-play')->with('status','Plugn and Play Modified Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PlugnPlay  $plugnPlay
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlugnPlay $plugnPlay,$id=0)
    {
        $del = PlugnPlay::find($id);
        $del->delete();
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Plugn and Play Deleted Successfully.');
    }
}

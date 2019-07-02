<?php

namespace App\Http\Controllers;

use App\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataTable = Feature::all();
        return view('admin.apps.pages.features.index',['dataTable'=>$dataTable]);
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
                'icon_image'=>'required',
            ]
        );

        $image = "";
        if (!empty($request->file('icon_image'))) {
            $img = $request->file('icon_image');
            $upload = 'upload/feature/';
            $image = time() . "." . $img->getClientOriginalExtension();
            $img->move($upload, $image);
        }

        $Feature=new Feature();
        $Feature->title=$request->title;
        $Feature->icon_image=$image;
        $Feature->save();
        
        
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Feature Saved Successfully.');
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
     * @param  \App\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function show(Feature $feature, $id=0)
    {
        $edit=Feature::find($id);
        $dataTable = Feature::all();
        return view('admin.apps.pages.features.index',compact('edit','dataTable'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function edit(Feature $feature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feature $feature, $id=0)
    {
        $this->validate($request,
            [
                'title'=>'required'
            ]
        );

        $image = $request->ex_image;
        if (!empty($request->file('icon_image'))) {
            $img = $request->file('icon_image');
            $upload = 'upload/feature/';
            $image = time() . "." . $img->getClientOriginalExtension();
            $img->move($upload, $image);
        }

        $Feature=Feature::find($id);
        $Feature->title=$request->title;
        $Feature->icon_image=$image;
        $Feature->save();
        
        
        return redirect ('admin-site/features')->with('status','Feature Modified Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feature $feature,$id=0)
    {
        $del = Feature::find($id);
        $del->delete();
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Feature Deleted Successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataTable = Slider::all();
        return view('admin.apps.pages.slider.index',['dataTable'=>$dataTable]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Request $request)
    {
        $this->validate($request,
            [
                'title'=>'required',
                'sub_title'=>'required',
                'image'=>'required',
                'demo_link'=>'required',
            ]
        );

        $image = "";
        if (!empty($request->file('image'))) {
            $img = $request->file('image');
            $upload = 'upload/slider/';
            $image = time() . "." . $img->getClientOriginalExtension();
            $img->move($upload, $image);
        }

        $Slider=new Slider();
        $Slider->title=$request->title;
        $Slider->sub_title=$request->sub_title;
        $Slider->image=$image;
        $Slider->demo_link=$request->demo_link;
        $Slider->save();
        
        
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Slider Saved Successfully.');
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
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider,$id=0)
    {
        $edit=Slider::find($id);
        $dataTable = Slider::all();
        return view('admin.apps.pages.slider.index',compact('edit','dataTable'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider,$id=0)
    {
        $this->validate($request,
            [
                'title'=>'required',
                'sub_title'=>'required',
                'demo_link'=>'required',
            ]
        );

        $image = $request->ex_image;
        if (!empty($request->file('image'))) {
            $img = $request->file('image');
            $upload = 'upload/slider/';
            $image = time() . "." . $img->getClientOriginalExtension();
            $img->move($upload, $image);
            @unlink($image);
        }

        $Slider=Slider::find($id);
        $Slider->title=$request->title;
        $Slider->sub_title=$request->sub_title;
        $Slider->image=$image;
        $Slider->demo_link=$request->demo_link;
        $Slider->save();
        
        
        return redirect ('admin-site/slider')->with('status','Slider Modified Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider,$id=0)
    {
        $del = Slider::find($id);
        $del->delete();
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Slider Deleted Successfully.');
    }
}

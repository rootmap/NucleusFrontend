<?php

namespace App\Http\Controllers;

use App\PlugnPlayImage;
use Illuminate\Http\Request;

class PlugnPlayImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataTable = PlugnPlayImage::all();
        return view('admin.apps.pages.plug-and-play.image',['dataTable'=>$dataTable]);
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
                
                'image'=>'required',
            ]
        );

        $image = "";
        if (!empty($request->file('image'))) {
            $img = $request->file('image');
            $upload = 'upload/plug-and-play/';
            $image = time() . "." . $img->getClientOriginalExtension();
            $img->move($upload, $image);
        }

        $Feature=new PlugnPlayImage();
        $Feature->image=$image;
        $Feature->save();
        
        
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Plugn and Play Image Saved Successfully.');
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
     * @param  \App\PlugnPlayImage  $plugnPlayImage
     * @return \Illuminate\Http\Response
     */
    public function show(PlugnPlayImage $PlugnPlayImage,$id=0)
    {
        $edit=PlugnPlayImage::find($id);
        $dataTable = PlugnPlayImage::all();
        return view('admin.apps.pages.plug-and-play.image',compact('edit','dataTable'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PlugnPlayImage  $plugnPlayImage
     * @return \Illuminate\Http\Response
     */
    public function edit(PlugnPlayImage $plugnPlayImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PlugnPlayImage  $plugnPlayImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlugnPlayImage $plugnPlayImage,$id=0)
    {
    
        $image = $request->ex_image;
        if (!empty($request->file('image'))) {
            $img = $request->file('image');
            $upload = 'upload/plug-and-play/';
            $image = time() . "." . $img->getClientOriginalExtension();
            $img->move($upload, $image);
        }

        $Feature=PlugnPlayImage::find($id);
        $Feature->image=$image;
        $Feature->save();
        return redirect ('admin-site/plug-and-play-image')->with('status','Plugn and Play Image Modified Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PlugnPlayImage  $plugnPlayImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlugnPlayImage $plugnPlayImage,$id=0)
    {
        $del = PlugnPlayImage::find($id);
        $del->delete();
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Plugn and Play Deleted Successfully.');
    }
}

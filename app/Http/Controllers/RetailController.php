<?php

namespace App\Http\Controllers;

use App\Retail;
use Illuminate\Http\Request;

class RetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkSetting=Retail::where('id',1)->count();
        if($checkSetting==1)
        {
            $editSetting=Retail::where('id',1)->first();
            return view('admin.apps.pages.retail.index',compact('editSetting'));
        }
        else
        {
            return view('admin.apps.pages.retail.index');
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
                'details'=>'required',
            ]
        );

        $about_image = "";
        if (!empty($request->file('image'))) {
            $img = $request->file('image');
            $upload = 'upload/retail_image/';
            $about_image = time() . "." . $img->getClientOriginalExtension();
            $img->move($upload, $about_image);
        }

        
        $SiteSetting=new Retail();
        $SiteSetting->title=$request->title;
        $SiteSetting->image=$about_image;
        $SiteSetting->details=$request->details;
        $SiteSetting->save();
        
        
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Retail Content Saved Successfully.');

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
     * @param  \App\Retail  $retail
     * @return \Illuminate\Http\Response
     */
    public function show(Retail $retail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Retail  $retail
     * @return \Illuminate\Http\Response
     */
    public function edit(Retail $retail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Retail  $retail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id=0)
    {
        $this->validate($request,
            [
                'title'=>'required',
                'details'=>'required',
            ]
        );

        $about_image = $request->ex_image;
        if (!empty($request->file('image'))) {
            $img = $request->file('image');
            $upload = 'upload/retail_image/';
            $about_image = time() . "." . $img->getClientOriginalExtension();
            $img->move($upload, $about_image);
        }

        
        $SiteSetting=Retail::find(1);
        $SiteSetting->title=$request->title;
        $SiteSetting->image=$about_image;
        $SiteSetting->details=$request->details;
        $SiteSetting->save();
        
        
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Retail Content Saved Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Retail  $retail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Retail $retail)
    {
        //
    }
}

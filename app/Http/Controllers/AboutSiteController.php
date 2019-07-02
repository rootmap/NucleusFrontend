<?php

namespace App\Http\Controllers;

use App\AboutSite;
use Illuminate\Http\Request;

class AboutSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkSetting=AboutSite::where('id',1)->count();
        if($checkSetting==1)
        {
            $editSetting=AboutSite::where('id',1)->first();
            return view('admin.apps.pages.about.index',compact('editSetting'));
        }
        else
        {
            return view('admin.apps.pages.about.index');
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
        if (!empty($request->file('about_image'))) {
            $img = $request->file('about_image');
            $upload = 'upload/about_image/';
            $about_image = time() . "." . $img->getClientOriginalExtension();
            $img->move($upload, $about_image);
        }

        $about_background_image = "";
        if (!empty($request->file('about_background_image'))) {
            $powered_by_logoimg = $request->file('about_background_image');
            $powered_by_logoupload = 'upload/about_background_image/';
            $about_background_image = time() . "." . $powered_by_logoimg->getClientOriginalExtension();
            $powered_by_logoimg->move($powered_by_logoupload, $about_background_image);
        }

        $SiteSetting=new AboutSite();
        $SiteSetting->title=$request->title;
        $SiteSetting->image=$about_image;
        $SiteSetting->background_image=$about_background_image;
        $SiteSetting->details=$request->details;
        $SiteSetting->save();
        
        
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Site Settings Saved Successfully.');

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
     * @param  \App\AboutSite  $aboutSite
     * @return \Illuminate\Http\Response
     */
    public function show(AboutSite $aboutSite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AboutSite  $aboutSite
     * @return \Illuminate\Http\Response
     */
    public function edit(AboutSite $aboutSite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AboutSite  $aboutSite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id=0)
    {
        $this->validate($request,
            [
                'title'=>'required',
                'details'=>'required',
            ]
        );

        

        $about_image = $request->ex_about_image;
        if (!empty($request->file('about_image'))) {
            $img = $request->file('about_image');
            $upload = 'upload/about_image/';
            $about_image = time() . "." . $img->getClientOriginalExtension();
            $img->move($upload, $about_image);
        }

        $about_background_image = $request->ex_about_background_image;
        if (!empty($request->file('about_background_image'))) {
            $powered_by_logoimg = $request->file('about_background_image');
            $powered_by_logoupload = 'upload/about_background_image/';
            $about_background_image = time() . "." . $powered_by_logoimg->getClientOriginalExtension();
            $powered_by_logoimg->move($powered_by_logoupload, $about_background_image);
        }

        $SiteSetting=AboutSite::find(1);
        $SiteSetting->title=$request->title;
        $SiteSetting->image=$about_image;
        $SiteSetting->background_image=$about_background_image;
        $SiteSetting->details=$request->details;
        $SiteSetting->save();
        
        
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','About Content Modified Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AboutSite  $aboutSite
     * @return \Illuminate\Http\Response
     */
    public function destroy(AboutSite $aboutSite)
    {
        //
    }
}

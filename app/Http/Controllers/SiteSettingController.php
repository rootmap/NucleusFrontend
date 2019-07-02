<?php

namespace App\Http\Controllers;

use App\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkSetting=SiteSetting::where('id',1)->count();
        if($checkSetting==1)
        {
            $editSetting=SiteSetting::where('id',1)->first();
            return view('admin.apps.pages.settings.index',compact('editSetting'));
        }
        else
        {
            return view('admin.apps.pages.settings.index');
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
                'site_name'=>'required',
                'address'=>'required',
                'phone'=>'required',
                'email'=>'required',
                'demo_link'=>'required',
            ]
        );

        $site_logo = "";
        if (!empty($request->file('site_logo'))) {
            $img = $request->file('site_logo');
            $upload = 'upload/site_logo/';
            $site_logo = time() . "." . $img->getClientOriginalExtension();
            $img->move($upload, $site_logo);
        }

        $powered_by_logo = "";
        if (!empty($request->file('powered_by_logo'))) {
            $powered_by_logoimg = $request->file('powered_by_logo');
            $powered_by_logoupload = 'upload/powered_by_logo/';
            $powered_by_logo = time() . "." . $powered_by_logoimg->getClientOriginalExtension();
            $powered_by_logoimg->move($powered_by_logoupload, $powered_by_logo);
        }

        $SiteSetting=new SiteSetting();
        $SiteSetting->site_name=$request->site_name;
        $SiteSetting->site_logo=$site_logo;
        $SiteSetting->powered_by_logo=$powered_by_logo;
        $SiteSetting->address=$request->address;
        $SiteSetting->phone=$request->phone;
        $SiteSetting->email=$request->email;
        $SiteSetting->demo_link=$request->demo_link;
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
     * @param  \App\SiteSetting  $siteSetting
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $editSetting=SiteSetting::find(1);
        return view('admin.apps.pages.settings.index',compact('editSetting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SiteSetting  $siteSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(SiteSetting $siteSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SiteSetting  $siteSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id=0)
    {
        $this->validate($request,
            [
                'site_name'=>'required',
                'address'=>'required',
                'phone'=>'required',
                'email'=>'required',
                'demo_link'=>'required',
            ]
        );

        $site_logo = $request->ex_site_logo;
        if (!empty($request->file('site_logo'))) {
            $img = $request->file('site_logo');
            $upload = 'upload/site_logo/';
            $site_logo = time() . "." . $img->getClientOriginalExtension();
            $img->move($upload, $site_logo);
        }

        $powered_by_logo = $request->ex_powered_by_logo;
        if (!empty($request->file('powered_by_logo'))) {
            $powered_by_logoimg = $request->file('powered_by_logo');
            $powered_by_logoupload = 'upload/powered_by_logo/';
            $powered_by_logo = time() . "." . $powered_by_logoimg->getClientOriginalExtension();
            $powered_by_logoimg->move($powered_by_logoupload, $powered_by_logo);
        }

        $SiteSetting=SiteSetting::find(1);
        $SiteSetting->site_name=$request->site_name;
        $SiteSetting->site_logo=$site_logo;
        $SiteSetting->powered_by_logo=$powered_by_logo;
        $SiteSetting->address=$request->address;
        $SiteSetting->phone=$request->phone;
        $SiteSetting->email=$request->email;
        $SiteSetting->demo_link=$request->demo_link;
        $SiteSetting->save();
        
        
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Site Settings Modified Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SiteSetting  $siteSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteSetting $siteSetting)
    {
        //
    }
}

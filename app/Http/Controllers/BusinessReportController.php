<?php

namespace App\Http\Controllers;

use App\BusinessReport;
use Illuminate\Http\Request;

class BusinessReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkSetting=BusinessReport::where('id',1)->count();
        if($checkSetting==1)
        {
            $edit=BusinessReport::where('id',1)->first();
            return view('admin.apps.pages.businessReports.index',compact('edit'));
        }
        else
        {
            return view('admin.apps.pages.businessReports.index');
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
                'background_image'=>'required',
                'detail'=>'required',
            ]
        );

        $site_logo = "";
        if (!empty($request->file('background_image'))) {
            $img = $request->file('background_image');
            $upload = 'upload/business-reports/';
            $site_logo = time() . "." . $img->getClientOriginalExtension();
            $img->move($upload, $site_logo);
        }

        $SiteSetting=new BusinessReport();
        $SiteSetting->title=$request->title;
        $SiteSetting->background_image=$site_logo;
        $SiteSetting->detail=$request->detail;
        $SiteSetting->save();
        
        
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Business Reports Saved Successfully.');
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
     * @param  \App\BusinessReport  $businessReport
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessReport $businessReport)
    {
        $edit=businessReport::find(1);
        return view('admin.apps.pages.businessReports.index',compact('edit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BusinessReport  $businessReport
     * @return \Illuminate\Http\Response
     */
    public function edit(BusinessReport $businessReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BusinessReport  $businessReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusinessReport $businessReport,$id=0)
    {
        $this->validate($request,
            [
                'title'=>'required',
                'detail'=>'required',
            ]
        );

        $site_logo = $request->ex_image;
        if (!empty($request->file('background_image'))) {
            $img = $request->file('background_image');
            $upload = 'upload/business-reports/';
            $site_logo = time() . "." . $img->getClientOriginalExtension();
            $img->move($upload, $site_logo);
        }

        $SiteSetting=BusinessReport::find($id);
        $SiteSetting->title=$request->title;
        $SiteSetting->background_image=$site_logo;
        $SiteSetting->detail=$request->detail;
        $SiteSetting->save();
        
        
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Business Reports Modified Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BusinessReport  $businessReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessReport $businessReport)
    {
        //
    }
}

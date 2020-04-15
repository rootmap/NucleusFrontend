<?php

namespace App\Http\Controllers;

use App\BusinessReportFeature;
use Illuminate\Http\Request;

class BusinessReportFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataTable = BusinessReportFeature::all();
        return view('admin.apps.pages.businessReports.features',['dataTable'=>$dataTable]);
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
            $upload = 'upload/business-reports/features/';
            $image = time() . "." . $img->getClientOriginalExtension();
            $img->move($upload, $image);
        }

        $Feature=new BusinessReportFeature();
        $Feature->title=$request->title;
        $Feature->sub_title=$request->sub_title;
        $Feature->icon_image=$image;
        $Feature->detail=$request->detail;
        $Feature->position=$request->position;
        $Feature->save();
        
        
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Business Reports Feature Saved Successfully.');
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
     * @param  \App\BusinessReportFeature  $businessReportFeature
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessReportFeature $businessReportFeature,$id=0)
    {
        $edit=BusinessReportFeature::find($id);
        $dataTable = BusinessReportFeature::all();
        return view('admin.apps.pages.businessReports.features',compact('edit','dataTable'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BusinessReportFeature  $businessReportFeature
     * @return \Illuminate\Http\Response
     */
    public function edit(BusinessReportFeature $businessReportFeature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BusinessReportFeature  $businessReportFeature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusinessReportFeature $businessReportFeature,$id=0)
    {
        $this->validate($request,
            [
                'title'=>'required',
            ]
        );

        $image = $request->ex_image;
        if (!empty($request->file('icon_image'))) {
            $img = $request->file('icon_image');
            $upload = 'upload/business-reports/features/';
            $image = time() . "." . $img->getClientOriginalExtension();
            $img->move($upload, $image);
        }

        $Feature=BusinessReportFeature::find($id);
        $Feature->title=$request->title;
        $Feature->sub_title=$request->sub_title;
        $Feature->icon_image=$image;
        $Feature->detail=$request->detail;
        $Feature->position=$request->position;
        $Feature->save();
        return redirect ('admin-site/business-reports-features')->with('status','Business Report Feature Modified Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BusinessReportFeature  $businessReportFeature
     * @return \Illuminate\Http\Response
     */
    public function destroy($id=0)
    {
        $del = BusinessReportFeature::find($id);
        $del->delete();
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Business Report Feature Deleted Successfully.');
    }
}

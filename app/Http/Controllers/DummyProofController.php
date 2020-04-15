<?php

namespace App\Http\Controllers;

use App\DummyProof;
use Illuminate\Http\Request;

class DummyProofController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkSetting=DummyProof::where('id',1)->count();
        if($checkSetting==1)
        {
            $editSetting=DummyProof::where('id',1)->first();
            return view('admin.apps.pages.dummyProof.index',compact('editSetting'));
        }
        else
        {
            return view('admin.apps.pages.dummyProof.index');
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
                'short_details'=>'required',
                'long_details'=>'required',
            ]
        );

        $site_logo = "";
        if (!empty($request->file('dummy_proof_image'))) {
            $img = $request->file('dummy_proof_image');
            $upload = 'upload/dummy_proof_image/';
            $site_logo = time() . "." . $img->getClientOriginalExtension();
            $img->move($upload, $site_logo);
        }

        $powered_by_logo = "";
        if (!empty($request->file('dummy_proof_background_image'))) {
            $powered_by_logoimg = $request->file('dummy_proof_background_image');
            $powered_by_logoupload = 'upload/dummy_proof_background_image/';
            $powered_by_logo = time() . "." . $powered_by_logoimg->getClientOriginalExtension();
            $powered_by_logoimg->move($powered_by_logoupload, $powered_by_logo);
        }

        $SiteSetting=new DummyProof();
        $SiteSetting->title=$request->title;
        $SiteSetting->image=$site_logo;
        $SiteSetting->background_image=$powered_by_logo;
        $SiteSetting->short_details=$request->short_details;
        $SiteSetting->long_details=$request->long_details;
        $SiteSetting->save();
        
        
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Dummy Proof Saved Successfully.');

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
     * @param  \App\DummyProof  $dummyProof
     * @return \Illuminate\Http\Response
     */
    public function show(DummyProof $dummyProof)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DummyProof  $dummyProof
     * @return \Illuminate\Http\Response
     */
    public function edit(DummyProof $dummyProof)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DummyProof  $dummyProof
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id=0)
    {
        $this->validate($request,
            [
                'title'=>'required',
                'short_details'=>'required',
                'long_details'=>'required',
            ]
        );

        $site_logo = $request->ex_dummy_proof_image;
        if (!empty($request->file('dummy_proof_image'))) {
            $img = $request->file('dummy_proof_image');
            $upload = 'upload/dummy_proof_image/';
            $site_logo = time() . "." . $img->getClientOriginalExtension();
            $img->move($upload, $site_logo);
        }

        $powered_by_logo = $request->ex_dummy_proof_background_image;
        if (!empty($request->file('dummy_proof_background_image'))) {
            $powered_by_logoimg = $request->file('dummy_proof_background_image');
            $powered_by_logoupload = 'upload/dummy_proof_background_image/';
            $powered_by_logo = time() . "." . $powered_by_logoimg->getClientOriginalExtension();
            $powered_by_logoimg->move($powered_by_logoupload, $powered_by_logo);
        }

        $SiteSetting=DummyProof::find(1);
        $SiteSetting->title=$request->title;
        $SiteSetting->image=$site_logo;
        $SiteSetting->background_image=$powered_by_logo;
        $SiteSetting->short_details=$request->short_details;
        $SiteSetting->long_details=$request->long_details;
        $SiteSetting->save();

        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Dummy Proof Modified Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DummyProof  $dummyProof
     * @return \Illuminate\Http\Response
     */
    public function destroy(DummyProof $dummyProof)
    {
        //
    }
}

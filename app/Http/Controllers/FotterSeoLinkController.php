<?php

namespace App\Http\Controllers;

use App\FotterSeoLink;
use Illuminate\Http\Request;

class FotterSeoLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataTable = FotterSeoLink::all();
        return view('admin.apps.pages.footer-menu.index',['dataTable'=>$dataTable]);
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
                'name'=>'required',
                'link'=>'required',
            ]
        );

        $FotterSeoLink=new FotterSeoLink();
        $FotterSeoLink->name=$request->name;
        $FotterSeoLink->link=$request->link;
        $FotterSeoLink->save();
        
        
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Footter Seo Link Saved Successfully.');
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
     * @param  \App\FotterSeoLink  $fotterSeoLink
     * @return \Illuminate\Http\Response
     */
    public function show(FotterSeoLink $fotterSeoLink,$id=0)
    {
        $edit=FotterSeoLink::find($id);
        $dataTable = FotterSeoLink::all();
        return view('admin.apps.pages.footer-menu.index',compact('edit','dataTable'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FotterSeoLink  $fotterSeoLink
     * @return \Illuminate\Http\Response
     */
    public function edit(FotterSeoLink $fotterSeoLink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FotterSeoLink  $fotterSeoLink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FotterSeoLink $fotterSeoLink,$id=0)
    {
        $this->validate($request,
            [
                'name'=>'required',
                'link'=>'required'
            ]
        );
        $FotterSeoLink=FotterSeoLink::find($id);
        $FotterSeoLink->name=$request->name;
        $FotterSeoLink->link=$request->link;
        $FotterSeoLink->save();
        
        
        return redirect ('admin-site/footer-menu')->with('status','Footter Seo Link Modified Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FotterSeoLink  $fotterSeoLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(FotterSeoLink $fotterSeoLink,$id=0)
    {
        $del = FotterSeoLink::find($id);
        $del->delete();
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Footter Seo Link Deleted Successfully.');
    }
}

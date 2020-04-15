<?php

namespace App\Http\Controllers;

use App\Price;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataTable = Price::all();
        return view('admin.apps.pages.price.index',['dataTable'=>$dataTable]);
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
                //'sub_title'=>'required',
                'price'=>'required',
                'sub_price'=>'required',
                'features'=>'required',
            ]
        );
        //dd($request->features);
        $features = json_encode($request->features);
        //dd($features);
    //foreach ($features as $index=>$fet){
            
        $Price=new Price();
        $Price->title=$request->title;
        $Price->sub_title=$request->sub_title;
        $Price->price=$request->price;
        $Price->sub_price=$request->sub_price;
        $Price->features=$features;
        $Price->save();
        //}
        
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Price Saved Successfully.');
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
     * @param  \App\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function show(Price $price,$id=0)
    {
        $edit=Price::find($id);
        $dataTable = Price::all();
        return view('admin.apps.pages.price.index',compact('edit','dataTable'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function edit(Price $price)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Price $price,$id=0)
    {
        $this->validate($request,
            [
                'title'=>'required',
                'price'=>'required',
                //'sub_price'=>'required',
                'features'=>'required',
            ]
        );
       

        $features = json_encode($request->features);
       
        $sub_price=$request->sub_price?$request->sub_price:'';
            
        $Price=Price::find($id);
        $Price->title=$request->title;
        $Price->sub_title=$request->sub_title;
        $Price->price=$request->price;
        $Price->sub_price=$sub_price;
        $Price->features=$features;
        $Price->save();
        //}
        
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Price Saved Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function destroy(Price $price,$id=0)
    {
        $del = Price::find($id);
        $del->delete();
        return redirect(url($_SERVER['HTTP_REFERER']))->with('status','Price Deleted Successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User; 

class LoloPinoyLechonDeCebuController extends Controller
{


    //all lists
    public function allLists(){
        $id =  Auth::user()->id;
        $user = User::find($id);

        return view('lechon-de-cebu-all-lists', compact('user'));
    }

    //purchase order
    public function purchaseOrder(){
        $id =  Auth::user()->id;
        $user = User::find($id);

        return view('lechon-de-cebu-purchase-order', compact('user'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $id =  Auth::user()->id;
        $user = User::find($id);

        return view('lolo-pinoy-lechon-de-cebu', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
         $this->validate($request, [
            'paidTo' => 'required|min:6',
            'address'=> 'required|min:6',
            'quantity'=>'required|min:6',
            'description'=>'required|min:6',
            'unitPrice'=>'required|min:6',
            'amount'=>'required|min:6',
        ]);

         

         

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

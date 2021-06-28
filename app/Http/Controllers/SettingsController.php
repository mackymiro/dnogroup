<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SettingsModel;

class SettingsController extends Controller
{

    public function addHeadFeet(Request $request){
        $flagBody = "headfeet";
      
        $target = DB::table(
                'settings_models')
                ->where('flag', $flagBody)
                ->get()->first();

        if($target == NULL){
            $addBody = new SettingsModel([
                'settings_head_feet'=>$request->headFeet,
            ]); 
    
            $addBody->save();
    
            return response()->json('Succesfully added price');
        }else{
            $UpdateDetails = SettingsModel::where('flag', $flagBody)->first();
           
            $UpdateDetails->settings_head_feet = $request->headFeet;
            $UpdateDetails->save();

            return response()->json('Succesfully updated price');
        }
      
    }

    public function addBody(Request $request){
        $flagBody = "body";
      
        $target = DB::table(
                'settings_models')
                ->where('flag', $flagBody)
                ->get()->first();

        if($target == NULL){
            $addBody = new SettingsModel([
                'settings_for_body'=>$request->settingsLechon,
            ]); 
    
            $addBody->save();
    
            return response()->json('Succesfully added price');
        }else{
            $UpdateDetails = SettingsModel::where('flag', $flagBody)->first();
           
            $UpdateDetails->settings_for_body = $request->settingsLechon;
            $UpdateDetails->save();

            return response()->json('Succesfully updated price');
        }
      
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $getBody = SettingsModel::get()->where('flag', 'body')->toArray();
        $getHead = SettingsModel::get()->where('flag', 'headfeet')->toArray();
      
        return view('settings', compact('getBody', 'getHead'));
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

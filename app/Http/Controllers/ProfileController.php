<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use Session; 


class ProfileController extends Controller
{
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


        return view('profile', compact('user'));
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
        $profile = User::find($id);
       
         $id =  Auth::user()->id;
        $user = User::find($id);

        return view('edit-profile', compact('profile', 'user'));

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
        $photo = $request->file('photo');
       
        if($photo == ""){
            // if user update without uploading profile picture

            $user = User::find($id);

            $user->first_name = $request->get('firstName');
            $user->last_name = $request->get('lastName');
            $user->save();

            Session::flash('updated', 'Profile successfully updated.');

            return redirect('profile/edit/'.$id);
        }else{
            $photo = $request->file('photo');
            
            $profileImageSaveAsName = time() . "." .$photo->getClientOriginalExtension();

            if($photo->getClientOriginalExtension() == "jpg"){
                //upload the file to uploads folder
                $upload_path = 'uploads/';
                $image = $upload_path . $profileImageSaveAsName;
                
                //move the image to uploads folder
                $success = $photo->move($upload_path, $profileImageSaveAsName);

                $user = User::find($id);
                $user->first_name = $request->get('firstName');
                $user->last_name = $request->get('lastName');
                $user->photo = $profileImageSaveAsName;
                $user->save();

                Session::flash('updated', 'Profile successfully updated.');
                return redirect('profile/edit/'.$id);

            }else if($photo->getClientOriginalExtension() == "png"){
                 //upload the file to uploads folder
                $upload_path = 'uploads/';
                $image = $upload_path . $profileImageSaveAsName;
                
                //move the image to uploads folder
                $success = $photo->move($upload_path, $profileImageSaveAsName);

                $user = User::find($id);
                $user->first_name = $request->get('firstName');
                $user->last_name = $request->get('lastName');
                $user->photo = $profileImageSaveAsName;
                $user->save();

                Session::flash('updated', 'Profile successfully updated.');
                return redirect('profile/edit/'.$id);

            }else if($photo->getClientOriginalExtension() == "jpeg"){
                 //upload the file to uploads folder
                $upload_path = 'uploads/';
                $image = $upload_path . $profileImageSaveAsName;

                 //move the image to uploads folder
                $success = $photo->move($upload_path, $profileImageSaveAsName);

                 $user = User::find($id);
                $user->first_name = $request->get('firstName');
                $user->last_name = $request->get('lastName');
                $user->photo = $profileImageSaveAsName;
                $user->save();

                Session::flash('updated', 'Profile successfully updated.');
                return redirect('profile/edit/'.$id);

            }else{

                Session::flash('err', 'Invalid file type.');

                return redirect('profile/edit/'.$id);
            }

        }
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

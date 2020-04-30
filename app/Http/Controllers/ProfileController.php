<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Auth;
use App\User;
use Session; 


class ProfileController extends Controller
{

    //
    public function storeCreateUser(Request $request){
         //validate
        $this->validate($request,[
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'userType'=>'required_without:userType|not_in:0',
        ]);


        //check if email address already exists
        $checkEmail = DB::table(
                        'users')
                        ->where('email', $request->get('email'))
                        ->get()->first();
        if ($checkEmail === NULL) {
            # code...
             $createUser = new User([
                'first_name'=>$request->get('firstName'),
                'last_name'=>$request->get('lastName'),
                'email'=>$request->get('email'),
                'password'=>bcrypt($request->get('password')),
                'role_type'=>$request->get('userType'),
            ]);

            $createUser->save();
            
            Session::flash('createSuccess', 'Successfully created a user.');

            return redirect('profile/create-user');
        }else{
             return redirect('profile/create-user')->with('error', 'Email already exists');

        }
    

    }

    //
    public function createUser(){
        $id =  Auth::user()->id;
        $user = User::find($id);

        return view('create-user', compact('user'));        
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

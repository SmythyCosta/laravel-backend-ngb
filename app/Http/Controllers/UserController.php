<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Imports Models
use App\Models\Setting;
use App\Menu;
use App\Submenu;
use App\UserRole;
use App\User;
use App\LibPDF\UserPDF;


//libs
use Excel;
use Hash;
use JWTAuth;
use JWTAuthException;


class UserController extends Controller
{

	private $user;
    
    public function __construct(User $user){
        $this->user = $user;
    }

    public function passwordUpdate(Request $request)
    {
        $id = $request->input('id');
        $currentPassword = $request->input('currentPassword');
        $confirmPassword = bcrypt(($request->input('confirmPassword')));
        $status = '';
        $mesg = '';
        $user = User::find($id);
        if (!Hash::check($currentPassword , $user->password)){
            $status = '500';
            $mesg = "Old password don't match";
        }else{
            $user->password = $confirmPassword;
            $user->save();
            $mesg = "password chnage successfully";
        }

        return response()->json(['status'=>$status,'mesg'=>$mesg]); 
        
    }

	public function profileUpdate(Request $request)
    {
        $id = $request->input('id');
        $user = User::find($id);;
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Get the contents of the file
            $contents = $file->openFile()->fread($file->getSize());
            $user->image = $contents;
        }
        
        $user->save();
        return response()->json(['status'=>200,'mesg'=>'Profile Update Success']); 
        
    }


}
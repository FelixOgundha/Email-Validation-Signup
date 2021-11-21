<?php

namespace App\Controllers;

class SignUp extends BaseController
{
    public function new()
    {
        return view('SignUp/new.php');
    }

    public function create(){
        $userDetails = $this->request->getPost();

        $user = new \App\Entities\User($userDetails);
       
        $UserModel = new \App\Models\UserModel();

        if($UserModel->insert($user)){
            echo 'Signup Success';
        }else{
            return redirect()->back()
                             ->with('errors',$UserModel->errors())
                             ->withInput();
        }
        
    }
}

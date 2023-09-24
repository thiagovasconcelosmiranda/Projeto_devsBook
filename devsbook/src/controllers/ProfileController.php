<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;

class ProfileController extends Controller {

    private $lloggedUser;

    public function __construct(){
       $this->lloggedUser =  UserHandler::ckeckLogin();
        if($this->lloggedUser === false){
           $this->redirect('/signin');
        }
    }

    public function index( $atts = []) {
        $id =  $this->lloggedUser->id;

        if(!empty($atts['id'])){
             $id =  $atts['id'];
        }

        $user = UserHandler::getUser($id);

        if(!$user){
         $this->redirect('/');
        }

        $this->render('profile', [
            'lloggedUser' =>$this->lloggedUser,
            'user' => $user
        ]);
    }

}
<?php
namespace src\controllers;

use \core\Controller;
use \models\User;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;

class HomeController extends Controller {
    private $lloggedUser;

    public function __construct(){
       $this->lloggedUser =  UserHandler::ckeckLogin();
        if($this->lloggedUser === false){
           $this->redirect('/signin');
        }
    }

    public function index() { 
        $page = intval(filter_input(INPUT_GET, 'page'));

        
        $feed = PostHandler::getHomeFeed(
            $this->lloggedUser->id,
            $page
        );

        $this->render('home', [
            'lloggedUser'=> $this->lloggedUser,
            'feed' =>$feed
        ]);
    }

}


<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;

class SearchController extends Controller {

    private $lloggedUser;

    public function __construct(){
       $this->lloggedUser =  UserHandler::ckeckLogin();
        if($this->lloggedUser === false){
           $this->redirect('/signin');
        }
    }

    public function index( $atts = []) {
        $searchTerm = filter_input(INPUT_GET, 's');

        if(empty($searchTerm)){
           $this->redirect('/');
        }
        $users = UserHandler::searchUser($searchTerm);

        $this->render('search', [
            'lloggedUser' => $this->lloggedUser,
            'searchTerm' => $searchTerm,
            'users' => $users
        ]);
    }

    

}
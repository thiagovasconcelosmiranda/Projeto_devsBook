<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;

class PostController extends Controller {
    private $lloggedUser;

    public function __construct(){
       $this->lloggedUser =  UserHandler::ckeckLogin();
        if($this->lloggedUser === false){
           $this->redirect('/signin');
        }
    }

    public function new() {
        $body = filter_input(INPUT_POST, 'body');

        if($body){
            PostHandler::addPost(
                $this->lloggedUser->id, 
                'text',
                 $body
            );
        }
            $this->redirect('/');
    }

}
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
        $page = intval(filter_input(INPUT_GET, 'page'));

        //Detectando o usuário acessado
        $id =  $this->lloggedUser->id;

        if(!empty($atts['id'])){
             $id =  $atts['id'];
        }

        $user = UserHandler::getUser($id, true);

        if(!$user){
         $this->redirect('/');
        }
        $datefrom = new \DateTime($user->birthdate);
        $dateTo = new \DateTime('today');
        $user->ageYears = $datefrom->diff($dateTo)->y;
        
        //Pegando informações de usuários
        $feed = PostHandler::getUserFreed(
            $id,
            $page, 
            $this->lloggedUser->id
        );
           
        //Verificar  se eu o usuário
        $isFollowing = false;

        if($user->id != $this->lloggedUser->id){
           $isFollowing = UserHandler::isFolloeing($this->lloggedUser->id, $user->id);
        }
       

        $this->render('profile', [
            'lloggedUser' =>$this->lloggedUser,
            'user' => $user,
            'feed' => $feed,
             'isFollowing'=> $isFollowing
        ]);
    }

    public function follow($atts){
       $to =intval($atts['id']);


       if(UserHandler::idExists($to)){
           if(UserHandler::isFolloeing($this->lloggedUser->id, $to)){ 
                //Não seguir
                UserHandler::unfollow($this->lloggedUser->id, $to);
           }  else{
               //seguir
               UserHandler::follow($this->lloggedUser->id, $to);
           }
       }

       $this->redirect('/profile/'.$to);
    }

    public function friends($atts=[]){
        $id =  $this->lloggedUser->id;

        if(!empty($atts['id'])){
             $id =  $atts['id'];
        }

        $user = UserHandler::getUser($id, true);

        if(!$user){
         $this->redirect('/');
        }
        $datefrom = new \DateTime($user->birthdate);
        $dateTo = new \DateTime('today');
        $user->ageYears = $datefrom->diff($dateTo)->y;

        $isFollowing = false;

        if($user->id != $this->lloggedUser->id){
           $isFollowing = UserHandler::isFolloeing($this->lloggedUser->id, $user->id);
        }

        $this->render('profile_friends',[
            'lloggedUser' =>$this->lloggedUser,
            'user' => $user,
            'isFollowing'=> $isFollowing
        ]);
    }

    public function photos($atts=[]){
        $id =  $this->lloggedUser->id;

        if(!empty($atts['id'])){
             $id =  $atts['id'];
        }

        $user = UserHandler::getUser($id, true);

        if(!$user){
         $this->redirect('/');
        }
        $datefrom = new \DateTime($user->birthdate);
        $dateTo = new \DateTime('today');
        $user->ageYears = $datefrom->diff($dateTo)->y;

        $isFollowing = false;

        if($user->id != $this->lloggedUser->id){
           $isFollowing = UserHandler::isFolloeing($this->lloggedUser->id, $user->id);
        }

        $this->render('profile_photos',[
            'lloggedUser' =>$this->lloggedUser,
            'user' => $user,
            'isFollowing'=> $isFollowing
        ]);
    }

    

}
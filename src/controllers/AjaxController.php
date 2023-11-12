<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;

class AjaxController extends Controller {
    private $lloggedUser;

    public function __construct(){
       $this->lloggedUser =  UserHandler::ckeckLogin();
        if($this->lloggedUser === false){
           header('Content-Type: application/json');
           echo json_encode(['error' => 'Usuario não logado']);
           exit;
        }
    }

    public function like($atts=[]) {
        $id = $atts['id'];

        if(PostHandler::isLiked($id, $this->lloggedUser->id)){
            PostHandler::deleteLike($id, $this->lloggedUser->id );
        }else{
            PostHandler::addLike($id,$this->lloggedUser->id );
        }  
    }

    public function comment(){
        $array =['error'=>''];
        
        $id = filter_input(INPUT_POST, 'id');
        $txt = filter_input(INPUT_POST, 'txt');

    
        if($id && $txt){
            PostHandler::addComment($id, $txt, $this->lloggedUser->id);
            $array['link'] = '/profile/'.$this->lloggedUser->id;
            $array['avatar'] ='/media/avatars/'.$this->lloggedUser->avatar;
            $array['name'] = $this->lloggedUser->name;
            $array['body'] = $txt;
         }
         else{
            $array =['error'=>'Dados não enviados'];
         }

        header('Content-Type: application/json');
         echo json_encode($array);
        
         
     
    }

    public function upload(){
        $array = ['error'=>''];

       
        if(isset($_FILES['photo']) && !empty($_FILES['photo']['tmp_name'])){
            $photo = $_FILES['photo'];
            $maxWidth = 800;
            $maxHeight = 800;
        
            if(in_array($photo['type'], ['image/png', 'image/jpg', 'image/jpeg'])){

                list($widthOrig, $heightOrig) = getimagesize($photo['tmp_name']);
                $ratio = $widthOrig /$heightOrig;
                $newWidth = $maxWidth;
                $newHeight = $maxHeight;
                $ratioMax = $maxWidth /$maxHeight;

                if($ratioMax > $ratio){
                   $maxWidth = $newHeight * $ratio;
                }else{
                    $maxHeight = $maxWidth / $ratio;
                }

                $finalImage = imagecreatetruecolor($maxWidth, $maxHeight);

                switch($photo['type']){
                    case 'image/png':
                       $image = imagecreatefrompng($photo['tmp_name']);
                    break;

                    case 'image/jpeg':
                        $image = imagecreatefromjpeg($photo['tmp_name']);
                     break;

                     case 'image/jpg':
                        $image = imagecreatefromjpg($photo['tmp_name']);
                     break;

                }
                imagecopyresampled(
                    $finalImage, $image, 
                    0,0,0,0,
                    $newWidth, $newHeight, $widthOrig, $heightOrig
                );

                $photoName = md5(time().rand(0,9999)).'.jpg';
                imagejpeg($finalImage, 'media/uploads/'.$photoName);
                
                PostHandler::addPost(
                    $this->lloggedUser->id ,
                    'photo',
                    $photoName
                );


        $array['photo'] =  $photoName;
            }
         }
        header('Content-Type: application/json');
        echo json_encode($array);
    }

}
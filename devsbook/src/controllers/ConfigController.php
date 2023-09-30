<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;

class ConfigController extends Controller {
   private $lloggedUser;

   public function __construct(){
     $this->lloggedUser =  UserHandler::ckeckLogin();
     if($this->lloggedUser === false){
        $this->redirect('/signin');
     }
    }  

    public function index() {
         $flash = '';
         if(!empty($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = "";
         }
        $this->render('config', [
            'lloggedUser' =>$this->lloggedUser,
            'flash' => $flash
        ]);
    }

    public function configActive(){

        $updateFilds =[];
        $name = filter_input(INPUT_POST, 'name');
        $birthdate = filter_input(INPUT_POST, 'birthdate');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $city= filter_input(INPUT_POST, 'city');
        $work = filter_input(INPUT_POST, 'work');
        $password = filter_input(INPUT_POST, 'password');
        $rep_password = filter_input(INPUT_POST, 'rep_password');

        $updateFilds['id'] = $this->lloggedUser->id;
        $updateFilds['name'] = $name;
        $updateFilds['email'] = $email;
        $updateFilds['city'] = $city;
        $updateFilds['work'] = $work;
        $updateFilds['password'] = $password;
        $updateFilds['rep_password'] = $rep_password;


        //avatar 
          if(isset($_FILES['avatar']) && !empty($_FILES['avatar']['tmp_name'])){
              $newAvatar = $_FILES['avatar'];
              if(in_array($newAvatar['type'], ['image/jpeg', 'image/jpg', 'image/png'])){
                 $avatarName = $this->cutImage($newAvatar, 200,200, 'media/avatars');
                 $updateFilds['avatar'] = $avatarName;

                 echo $updateFilds['avatar'];
              }  
          }


        //cover
        if(isset($_FILES['cover']) && !empty($_FILES['cover']['tmp_name'])){
            $newCover = $_FILES['cover'];
            if(in_array($newCover['type'], ['image/jpeg', 'image/jpg', 'image/png'])){
               $CoverName = $this->cutImage($newCover, 850, 310, 'media/covers' );
               $updateFilds['cover'] = $CoverName;
            } 
        }

        if($name && $birthdate && $email && $city && $work){
            $birthdate = explode('/', $birthdate);

            if(count($birthdate) != 3){
               $_SESSION['flash'] =  'Data nascimento invalida!';
               $this->redirect('/signup');
            }
   
            $birthdate = $birthdate[2]. '-' .$birthdate['1']. '-'.$birthdate['0'];
            $updateFilds['birthdate'] = $birthdate;
               
            if(strtotime($birthdate === false)){
               $_SESSION['flash'] =  'Data nascimento invalida!';
               $this->redirect('/signup');
            }
            if(UserHandler::emailExists($updateFilds['email']) === false){
                
                if($updateFilds['password'] === $updateFilds['rep_password']){
                    $user = UserHandler::updateUser($updateFilds);

                    if($user){
                      $_SESSION['flash'] =  'Alterardo com sucesso!';
                    }
                }else{
                    $_SESSION['flash'] =  'Senhas não confere!';
                }   
            }else{
                $_SESSION['flash'] =  'Email existe já!';
            }
            
        }
        $this->redirect('/config');
    }




    private function cutImage( $file, $w, $h , $folder){

    
        
       list($widthOrig, $heightOrig) = getimagesize($file['tmp_name']);

       $ratio = $widthOrig / $heightOrig;
       $newWidth = $w;
       $newHeight = $newWidth / $ratio;

       if($newHeight < $h){
          $newHeight = $h;
          $newWidth  = $newHeight * $ratio;
       }

       $x = $w - $newWidth;
       $y = $h - $newHeight;
       $x - $x < 0 ? $x / 2 : $x;
       $y  - $y < 0 ? $y / 2 : $y;

       $finalImage = imagecreatetruecolor($w, $h);
       
       switch($file['type']){
           case 'image/jpeg':
                $image = imagecreatefromjpeg($file['tmp_name']);
            break;

           case 'image/jpg':
                 $image = imagecreatefromjpg($file['tmp_name']);
            break;

           case 'image/png':
            $image = imagecreatefrompng($file['tmp_name']);
            break;
       }

       imagecopyresampled(
          $finalImage, $image,
           $x, $y, 0, 0,
           $newWidth, $newHeight, $widthOrig, $heightOrig
       );

       $fileName = md5(time().rand(0,9999)).'.jpg';
       imageJpeg($finalImage, $folder. '/'. $fileName);
       print_r($fileName);
       return $fileName;
    

    }
} 
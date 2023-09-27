<?=$render('header', ['lloggedUser'=> $lloggedUser]);?>

<section class="container main">
    <?=$render('sidebar', ['activeMenu'=> 'profile']);?>
    <section class="container main">
      <section class="feed mt-10">
           <div class="row">
                <div class="column pr-5">
                   <h1>Você pesquisou por: <?=$searchTerm;?></h1>
                    <div class="full-friend-list">
                      <?php foreach($users as $user):?>
                       <div class="friend-icon">
                          <a href="<?=$base;?>/profile/<?=$user->id;?>">
                            <div class="friend-icon-avatar">
                               <img src="<?=$base;?>/media/avatars/<?=$user->avatar;?>" />
                            </div>
                            <div class="friend-icon-name">
                              <?=$user->name;?>
                            </div>
                          </a>
                      </div>
                    <?php  endforeach;?>
                     </div>
                </div>
                 <div class="column side pl-5">
                    <?=$render('rigth-side')?>
                </div>
            </div>

      </section>
</session>
<?=$render('footer');?>



   
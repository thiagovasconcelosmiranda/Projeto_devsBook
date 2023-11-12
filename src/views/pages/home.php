<?=$render('header', ['lloggedUser'=> $lloggedUser]);?>

<section class="container main">
    <?=$render('sidebar', ['activeMenu'=> 'home']);?>
    <section class="feed mt-10">
            <div class="row">
                <div class="column pr-5">
                   <?=$render('feed-edit', ['user'=>$lloggedUser]);?>
                   
                   <?php foreach($feed['posts'] as $data): ?>
                     <?=$render('feed-item', [
                        'data'=> $data,
                        'user' => $lloggedUser
                        ]);?>
                   <?php endforeach; ?>
                   <div class="feed-pagination">
                     <?php for($q=0; $q < $feed['pageCount']; $q++ ):?>  
                        <a  class='<?=($q==$feed['currentPage'] ? 'active': '')?>' href="<?=$base;?>?page=<?=$q?>"> <?=$q+1?></a>
                     <?php endfor;?>
                   </div>
                </div>
                 <div class="column side pl-5">
                    <?=$render('rigth-side')?>
                </div>
            </div>
        </section>
    </section>
    
    <?=$render('footer');?>
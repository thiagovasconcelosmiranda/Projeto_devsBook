<?=$render('header', ['lloggedUser'=> $lloggedUser]);?>
<section class="container main">
    <?=$render('sidebar', ['activeMenu'=> 'home']);?>
    <section class="feed mt-10">
        <h1>Configurações</h1>
            <?php if($flash): ?>
                <div class="alert-form">
                    <h3><?= $flash;?></h3>
                </div>
              
            <?php endif; ?>
       <form method="POST" action="<?=$base;?>/config" enctype="multipart/form-data">
          <section class="feed mt-10">
            <label for="">Novo Avatar</label><br><br>
            <input type="file" name="avatar">
          </section>
          <section class="feed mt-10">
            <label for="">Novo Capa</label><br><br>
            <input type="file" name="cover">
          </section><br>
          <hr/>
          <section class="feed mt-10">
              <label>Nome Completo:</label><br>
              <input type="text" class="input" name="name" value="<?=$lloggedUser->name;?>"/>
          </section>
          <section class="feed mt-10">
              <label>Data de nascimento:</label><br>
              <input type="text" class="input" name="birthdate" id="birt" value="<?= date('d/m/Y', strtotime($lloggedUser->birthdate));?>"/>
          </section>
          <section class="feed mt-10">
              <label>Email:</label><br>
              <input type="email" class="input" name="email" value="<?=$lloggedUser->email;?>"/>
          </section>
          <section class="feed mt-10">
              <label>Cidade:</label><br>
              <input type="text" class="input" name="city" value="<?=$lloggedUser->city;?>"/>
          </section>
          <section class="feed mt-10">
              <label>Trabalho:</label><br>
              <input type="text" class="input" name="work" value="<?=$lloggedUser->work;?>"/>
          </section>
          <hr>
          <section class="feed mt-10">
              <label>Nova senha:</label><br>
              <input type="password" class="input" name="password"/>
          </section>
          <section class="feed mt-10">
              <label>Confirmar senha:</label><br>
              <input type="password" class="input" name="rep_password"/>
          </section>
          <input class="button" type="submit" value="Salvar" />
        </form>
    </section> 
</section>
<script src="https://unpkg.com/imask"></script>
<script>
    IMask(
        document.getElementById('birt'),
        {
          mask: '00/00/0000'  
        }
    )
</script>
<?=$render('footer');?>



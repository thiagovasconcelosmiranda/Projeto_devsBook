<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
    <link rel="stylesheet" href="<?=$base;?>/assets/css/styles.css" />
    <link rel="stylesheet" href="<?=$base;?>/assets/css/feed-items.css" />
    <script src=" https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="<?=$base;?>/profile"><img src="<?=$base;?>/assets/images/devsbook_logo.png"/></a>
            </div>
            <div class="head-side">
                <div class="head-side-left">
                    <div class="search-area">
                        <form method="GET" action="<?=$base;?>/search">
                            <input type="search" placeholder="Pesquisar" name="s"/>
                        </form>
                    </div>
                </div>
                <div class="head-side-right">
                    <a href="<?=$base;?>/profile" class="user-area">
                        <div class="user-area-text"><?=$lloggedUser->name?></div>
                        <div class="user-area-icon">
                            <img src="<?=$base;?>/media/avatars/<?=$lloggedUser->avatar;?>"/>
                        </div>
                    </a>
                    <a href="<?=$base;?>/out" class="user-logout">
                          <img src="<?=$base;?>/assets/images/power_white.png"/>
                    </a>
                </div>
            </div>
        </div>
    </header>
    
            
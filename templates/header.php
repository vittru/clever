<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Клевер экомаркет</title>

        <link rel="icon" href="/images/icon.png">

        <link href="/css/search.css" rel="stylesheet">

        <link href="/css/font-awesome.css" rel="stylesheet">
        <link href="/css/bootstrap.css" rel="stylesheet">   
        <link href="/css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/css/slick.css">
        <link id="switcher" href="/css/clubclever-theme.css" rel="stylesheet">
        <link href="/css/sequence-theme.modern-slide-in.css" rel="stylesheet" media="all">
        <link href="/css/clubclever.css" rel="stylesheet">    
        <link href="/css/sumoselect.css" rel="stylesheet">    
        
        <!--link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'-->
        <!--link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'-->
       
        <!-- Yandex.Metrika counter -->
        <!--script type="text/javascript">
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter44412517 = new Ya.Metrika({
                            id:44412517,
                            clickmap:true,
                            trackLinks:true,
                            accurateTrackBounce:true
                        });
                    } catch(e) { }
                });

                var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () { n.parentNode.insertBefore(s, n); };
                s.type = "text/javascript";
                s.async = true;
                s.src = "https://mc.yandex.ru/metrika/watch.js";

                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else { f(); }
            })(document, window, "yandex_metrika_callbacks");
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/44412517" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body> 
    <!-- SCROLL TOP BUTTON -->
    <a class="scrollToTop green-button" href="#"><i class="fa fa-chevron-up"></i></a>
    <!-- END SCROLL TOP BUTTON -->

    <!-- Start header section -->
    <header id="aa-header">
        <!-- start header top  -->
        <div class="aa-header-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="aa-header-top-area">
                            <!-- start header top left -->
                            <div class="aa-header-top-left">
                                <a class="btn" href="/common/delivery" type="button">Доставка</a>
                                <a class="btn" href="/common/payment" type="button">Оплата</a>
                                <a class="btn hidden-xs hidden-sm" href="/common/bonus" type="button">Бонусы</a>
                                <a class="btn hidden-xs" href="/common/moneyback" type="button">Возврат</a>
                                <a class="btn hidden-xs hidden-sm hidden-md" href="/common/blog" type="button">Блог</a>
                                <a class="btn" href="/contacts" type="button">Контакты</a>

                                <div class="cellphone hidden-xs">
                                    <p><span class="fa fa-phone"></span>+7-996-725-00-61</p>
                                </div>
                                <div class="cellphone hidden-xs hidden-sm hidden-md">
                                    <p><span class="fa fa-phone"></span>+7-996-725-00-62</p>
                                </div>
                            </div>    
                            <div class="aa-header-top-right">
                                <ul class="aa-head-top-nav-right">
                                    <?php
                                    if ($user->name) {
                                    ?>
                                        <li>Добро пожаловать<a href="/account"><?php echo $user->name; ?></a></li>
                                    <?php
                                    } else {
                                    ?>
                                        <li><a href="" data-toggle="modal" data-target="#login-modal" class="btn">Войти/Зарегистрироваться</a></li>
                                        <li><a class="btn" href="/account/orders">Отследить заказ</a></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / header top  -->

        <!-- start header bottom  -->
        <div class="aa-header-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="aa-header-bottom-area">
                            <!-- logo  -->
                            <div class="aa-logo">
                                <a href="/">
                                    <img src="/images/logo.png" height='80px' alt="Экомаркет Клевер">  
                                </a>
                            </div>
                            <!-- / logo  -->
                            <!-- cart box -->
                            <?php
                            if (!isset($_SESSION['cart']))
                                $count = 0;
                            else        
                                $count = count($_SESSION['cart']);
                            ?>
                            <div class="aa-cartbox" id="cartbox">
                                <a class="aa-cart-link" <?php if($count) echo 'href="/cart"'; ?>>
                                    <span class="fa fa-shopping-basket"></span>
                                    <span class="aa-cart-title">Корзина<?php if ($total >= $this->registry['presentSum']) echo ' с подарком' ?></span>
                                    <?php
                                    if ($count) {
                                    ?>
                                        <span class="aa-cart-notify"><?php echo $count; ?></span>
                                    <?php 
                                    }
                                    ?>
                                </a>
                                <div class="aa-cartbox-summary">
                                    <ul>
                                        <li>
                                            <img class="aa-cartbox-img" src="/images/goods/present.jpg" alt="Подарок">
                                            <div class="aa-cartbox-info">
                                                <h4>
                                                <?php
                                                if ($total >= $this->registry['presentSum'])
                                                    echo 'Ваш личный подарок от Экомаркет "Клевер"';
                                                else
                                                    echo 'Оформите заказ на&nbsp;' . $this->registry['presentSum'] . ' рублей и&nbsp;получите подарок!';
                                                ?>
                                                </h4>
                                            </div>
                                        </li>
                                        <?php
                                        if ($count) {
                                            foreach ($_SESSION['cart'] as $cartItem) {
                                                $good = $this->registry['model']->getGood($cartItem->goodId);
                                                $size = $good->sizes[$cartItem->sizeId];
                                            ?>
                                                <li>
                                                    <a class="aa-cartbox-img" href="/showgood?id=<?php echo $good->id ?>"><img src="<?php echo $good->getImage() ?>" alt="<?php echo $good->name ?>"></a>
                                                    <div class="aa-cartbox-info">
                                                        <a href="/showgood?id=<?php echo $good->id; ?>"><h4><?php echo $good->name ?> <?php echo $size->size ?></h4></a>
                                                        <p><?php echo $cartItem->quantity ?> x <?php echo $cartItem->price . ' руб.' ?></p>
                                                    </div>
                                                    <a class="aa-remove-product" id="<?php echo $cartItem->goodId; ?>" value="<?php echo $cartItem->sizeId; ?>"><span class="fa fa-times"></span></a>
                                                </li>
                                            <?php
                                            }
                                        }    
                                        ?>
                                        <li>
                                            <span class="aa-cartbox-total-title">Всего покупок</span>
                                            <span class="aa-cartbox-total-price">
                                                <?php echo $total ?> руб.
                                            </span>
                                        </li>
                                    </ul>
                                    <?php 
                                    if ($count) { 
                                        ?>  
                                        <a class="aa-cartbox-checkout green-button" href="/buy">Купить</a>
                                    <?php 
                                    } 
                                    ?>
                                </div>
                            </div>
                            <!-- / cart box -->
                            <!-- search box -->
                            <form class="form-horizontal" role="form" action="/search">
                                <div class="input-group aa-search-box" id="adv-search">
                                    <input id="search-text" type="text" class="form-control" name="name" placeholder="Поиск по каталогу" />
                                    <div class="input-group-btn">
                                        <div class="btn-group" role="group">
                                            <div id="search-dropdown" class="dropdown dropdown-lg">
                                                <!--button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button-->
                                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                                    <div class="row">
                                                        <div class="form-group col-sm-6">
                                                            <select class="form-control" name="type">
                                                                <option value="0" disabled selected>Для кого</option>
                                                                <?php
                                                                foreach($this->registry['types'] as $key=>$value) {
                                                                    echo "<option value=".$key.">".$value."</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-sm-6">
                                                            <select class="form-control" name="firm">
                                                                <option value="0" disabled selected>Бренд</option>
                                                                <?php
                                                                foreach($this->registry['firms'] as $id=>$firm) {
                                                                    echo "<option value=".$id.">".$firm->name."</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>    
                                                    <div class="row">
                                                        <div class="form-group col-sm-6">
                                                            <select class="form-control" name="supercat">
                                                                <option value="0" disabled selected>Тип</option>
                                                                <?php
                                                                foreach($this->registry['supercats'] as $id=>$name) {
                                                                    echo "<option value=".$id.">".$name."</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-sm-6">
                                                            <select class="form-control" name="category">
                                                                <option value="0" selected disabled>Категория</option>
                                                                <?php
                                                                foreach($this->registry['categories'] as $id=>$name) {
                                                                    echo "<option value=".$id.">".$name."</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>    
                                                    <div class="row">  
                                                        <div class="form-group col-sm-6">
                                                            <select class="form-control" name="problem">
                                                                <option value="0" selected disabled>Проблема</option>
                                                                <?php
                                                                foreach($this->registry['problems'] as $id=>$name) {
                                                                    echo "<option value=".$id.">".$name."</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-sm-6"> 
                                                            <select class="form-control" name="effect">
                                                                <option value="0" selected disabled>Эффект</option>
                                                                <?php
                                                                foreach($this->registry['effects'] as $id=>$name) {
                                                                    echo "<option value=".$id.">".$name."</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">  
                                                        <div class="form-group col-sm-6">
                                                            <select class="form-control" name="skintype">
                                                                <option value="0" selected disabled>Тип кожи</option>
                                                                <?php
                                                                foreach($this->registry['skintypes'] as $id=>$name) {
                                                                    echo "<option value=".$id.">".$name."</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-sm-6">
                                                            <select class="form-control" name="hairtype">
                                                                <option value="0" selected disabled>Тип волос</option>
                                                                <?php
                                                                foreach($this->registry['hairtypes'] as $id=>$name) {
                                                                    echo "<option value=".$id.">".$name."</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>    
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="description" placeholder="Описание" />
                                                    </div>
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="madeOf" placeholder="Состав"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="howTo" placeholder="Способ применения" />
                                                    </div>
                                                    <button type="submit" class="btn orange-button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn orange-button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- / search box -->             
                    </div>
                </div>
            </div>
        </div>
        <!-- / header bottom  -->
    </header>
    <!-- / header section -->

    <!-- menu -->
    <section id="menu">
        <div class="container">
            <div class="menu-area">
                <!-- Navbar -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Показать меню</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>          
                    </div>
                    <div class="navbar-collapse collapse">
                        <!-- Left nav -->
                        <ul class="nav navbar-nav">
                            <li><a href="/catalog/type">Каталог<span class="caret"></a>
                                <ul class="dropdown-menu">
                                    <?php 
                                    foreach ($this->registry['types'] as $key => $value) {
                                    ?>
                                        <li>
                                            <a href="/catalog/type?id=<?php echo $key; ?>">
                                                <?php echo $value; ?>
                                            </a>
                                        </li>        
                                    <?php        
                                    } 
                                    ?>  
                                </ul>
                            </li>
                            <li><a href="/catalog/category/toys">Игрушки</a></li>
                            <li><a href="/catalog/category/presents">Подарки</a></li>
                            <li><a href="/catalog/category/suit">Наборы</a></li>
                            <li><a href="/catalog/firm">Бренды<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php 
                                    foreach ($this->registry['firms'] as $id => $firm) {
                                    ?>
                                        <li>
                                            <a href="/catalog/firm/<?php echo $firm->url; ?>">
                                                <?php echo $firm->name; ?>
                                            </a>
                                        </li>        
                                    <?php        
                                    } 
                                    ?>  
                                </ul>
                            </li>
                            <li><a href="/actions">Акции<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="/actions/bestbefore">
                                            Истекающие сроки
                                        </a>
                                    </li>        
                                    <li>
                                        <a href="/actions/discounts">
                                            Скидки
                                        </a>
                                    </li>        
                                </ul>
                            </li>
                            <li><a href="/news">Новости</a></li>
                        </ul>
                    </div>
                </div>
            </div>       
        </div>
    </section>
    <!-- / menu -->

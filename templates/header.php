<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php
        if ($metaDescription) {
        ?>
            <meta name="description" content="<?php echo $metaDescription ?>">
        <?php
        }
        if ($metaKeywords) {
        ?>
            <meta name="keywords" content="<?php echo $metaKeywords ?>">
        <?php
        }
        if ($metaTitle) {
        ?>
            <title><?php echo $metaTitle ?></title>
        <?php
        } else {
        ?>
            <title>Экомаркет Клевер</title>
        <?php 
        }
        ?>

        <link rel="icon" href="/images/icon.png">

        <link href="/css/search.min.css" rel="stylesheet">

        <link href="/css/font-awesome.css" rel="stylesheet">
        <link href="/css/bootstrap.css" rel="stylesheet">   
        <link href="/css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/css/slick.css">
        <link id="switcher" href="/css/clubclever-theme.min.css?v=20181101" rel="stylesheet">
        <link href="/css/sequence-theme.modern-slide-in.css" rel="stylesheet" media="all">
        <link href="/css/clubclever.min.css?v=20181101" rel="stylesheet">    
        <link href="/css/sumoselect.css" rel="stylesheet">    
        
        <!--link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'-->
        <!--link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'-->
       
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript" >
            var host = window.location.hostname;
            if(host != "localhost") {
                (function (d, w, c) {
                    (w[c] = w[c] || []).push(function() {
                        try {
                            w.yaCounter44412517 = new Ya.Metrika2({
                                id:44412517,
                                clickmap:true,
                                trackLinks:true,
                                accurateTrackBounce:true,
                                webvisor:true,
                                ecommerce:"dataLayer"
                            });
                        } catch(e) { }
                    });

                    var n = d.getElementsByTagName("script")[0],
                        s = d.createElement("script"),
                        f = function () { n.parentNode.insertBefore(s, n); };
                    s.type = "text/javascript";
                    s.async = true;
                    s.src = "https://mc.yandex.ru/metrika/tag.js";

                    if (w.opera == "[object Opera]") {
                        d.addEventListener("DOMContentLoaded", f, false);
                    } else { f(); }
                })(document, window, "yandex_metrika_callbacks2");
            };
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
    <a class="scrollToTop green button" href="#"><i class="fa fa-chevron-up"></i></a>
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
                                <a class="btn left" href="/common/delivery" type="button">Доставка</a>
                                <a class="btn left" href="/common/payment" type="button">Оплата</a>
                                <a class="btn left hidden-xs" href="/common/moneyback" type="button">Возврат</a>
                                <a class="btn left hidden-xs hidden-sm hidden-md" href="/common/blog" type="button">Блог</a>
                                <a class="btn left" href="/contacts" type="button">Контакты</a>
                                <a class="btn left hidden-xs hidden-sm" href="/common/vocabulary" type="button">Словарь</a>

                                <div class="cellphone left hidden-xs">
                                    <p><span class="fa fa-phone"></span><span class="ya-phone"><?php echo phoneNumber ?></span></p>
                                </div>
                            </div>    
                            <div class="right">
                                <div class="aa-header-top-right">
                                    <?php
                                    if ($user->name) {
                                    ?>
                                        <div class="aa-header-top-welcome">Добро пожаловать <a href="/account"><?php echo $user->name; ?></a></div>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="" data-toggle="modal" data-target="#login-modal" class="btn">Войти/Зарегистрироваться</a>
                                        <a class="btn" href="/account/orders">Отследить заказ</a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / header top  -->

        <!-- start header bottom  -->
        <div class="aa-header-bottom left">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- logo  -->
                        <div class="aa-logo left">
                            <a href="/">
                                <img src="/images/logo.png" alt="Экомаркет Клевер">  
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
                                <span class="aa-cart-title">
                                    <?php 
                                    if ($count) {
                                        echo 'Корзина';
                                        if ($total >= $this->registry['presentSum']) {
                                            echo ' с подарком';
                                        }
                                    } else {
                                        echo 'Пустая корзина';
                                    }
                                    ?>
                                </span>
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
                                            <div class="cart-good">
                                            <?php
                                            if ($total >= $this->registry['presentSum']) {
                                                echo 'Ваш личный подарок от Экомаркет "Клевер"';
                                            } else {
                                                echo 'Оформите заказ на&nbsp;' . $this->registry['presentSum'] . ' рублей и&nbsp;получите подарок!';
                                            }
                                            ?>
                                            </div>
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
                                                    <a href="/showgood?id=<?php echo $good->id; ?>"><div class="cart-good"><?php echo $good->name ?> <?php echo $size->size ?></div></a>
                                                    <p><?php echo $cartItem->quantity ?> x <?php echo $cartItem->price . currency ?></p>
                                                </div>
                                                <a class="aa-remove-product" id="<?php echo $cartItem->goodId; ?>" value="<?php echo $cartItem->sizeId; ?>"><span class="fa fa-times"></span></a>
                                            </li>
                                        <?php
                                        }
                                    }    
                                    ?>
                                    <li>
                                        <span class="aa-cartbox-total left">Всего на сумму</span>
                                        <span class="aa-cartbox-total right">
                                            <?php echo $total . currency ?>
                                        </span>
                                    </li>
                                </ul>
                                <?php 
                                if ($count) { 
                                    ?>  
                                    <a class="aa-cartbox-checkout green button" href="/buy">Купить</a>
                                <?php 
                                } 
                                ?>
                            </div>
                        </div>
                        <!-- / cart box -->
                        <!-- search box -->
                        <form class="form-horizontal" role="form" action="/search">
                            <div class="input-group aa-search-box" id="adv-search">
                                <input id="search-text" type="text" class="form-control" name="name" placeholder="Поиск по каталогу" <?php if (isset($search_text)) echo 'value="'.$search_text.'"' ?> />
                                <div class="input-group-btn">
                                    <div class="btn-group" role="group">
                                        <div id="search-dropdown" class="dropdown dropdown-lg">
                                            <!--button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button-->
                                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                                <div class="row">
                                                    <div class="form-group col-sm-6">
                                                        <select class="form-control" name="type">
                                                            <option value="0" <?php if (!isset($search_type)) echo 'selected disabled' ?>>Для кого</option>
                                                            <?php
                                                            foreach($this->registry['types'] as $id=>$type) {
                                                                echo "<option value=" . $id;
                                                                if (isset($search_type) and $search_type == $id)
                                                                    echo " selected";
                                                                echo ">" .$type->name . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <select class="form-control" name="firm">
                                                            <option value="0" <?php if (!isset($search_firm)) echo 'selected disabled' ?>>Бренд</option>
                                                            <?php
                                                            foreach($this->registry['firms'] as $id=>$firm) {
                                                                echo "<option value=" . $id;
                                                                if (isset($search_firm) and $search_firm == $id)
                                                                    echo " selected";
                                                                echo ">" . $firm->name . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>    
                                                <div class="row">
                                                    <div class="form-group col-sm-6">
                                                        <select class="form-control" name="supercat">
                                                            <option value="0" <?php if (!isset($search_supercat)) echo 'selected disabled' ?>>Тип</option>
                                                            <?php
                                                            foreach($this->registry['supercats'] as $sc) {
                                                                echo "<option value=".$sc->id;
                                                                if (isset($search_supercat) and $search_supercat == $sc->id)
                                                                    echo " selected";
                                                                echo ">" . $sc->name . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <select class="form-control" name="category">
                                                            <option value="0" <?php if (!isset($search_category)) echo 'selected disabled' ?>>Категория</option>
                                                            <?php
                                                            foreach($this->registry['categories'] as $id=>$name) {
                                                                echo "<option value=" . $id;
                                                                if (isset($search_category) and $search_category == $id)
                                                                    echo " selected";
                                                                echo ">" . $name . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>    
                                                <div class="row">  
                                                    <div class="form-group col-sm-6">
                                                        <select class="form-control" name="problem">
                                                            <option value="0" <?php if (!isset($search_problem)) echo 'selected disabled' ?>>Проблема</option>
                                                            <?php
                                                            foreach($this->registry['problems'] as $id=>$name) {
                                                                echo "<option value=" . $id;
                                                                if (isset($search_problem) and $search_problem == $id)
                                                                    echo " selected";
                                                                echo ">" . $name . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-6"> 
                                                        <select class="form-control" name="effect">
                                                            <option value="0" <?php if (!isset($search_effect)) echo 'selected disabled' ?>>Эффект</option>
                                                            <?php
                                                            foreach($this->registry['effects'] as $id=>$name) {
                                                                echo "<option value=" . $id;
                                                                if (isset($search_effect) and $search_effect == $id)
                                                                    echo " selected";
                                                                echo ">" . $name . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">  
                                                    <div class="form-group col-sm-6">
                                                        <select class="form-control" name="skintype">
                                                            <option value="0" <?php if (!isset($search_skinType)) echo 'selected disabled' ?>>Тип кожи</option>
                                                            <?php
                                                            foreach($this->registry['skintypes'] as $id=>$name) {
                                                                echo "<option value=" . $id;
                                                                if (isset($search_skinType) and $search_skinType == $id)
                                                                    echo " selected";
                                                                echo ">" . $name . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <select class="form-control" name="hairtype">
                                                            <option value="0" <?php if (!isset($search_hairType)) echo 'selected disabled' ?>>Тип волос</option>
                                                            <?php
                                                            foreach($this->registry['hairtypes'] as $id=>$name) {
                                                                echo "<option value=" . $id;
                                                                if (isset($search_hairType) and $search_hairType == $id)
                                                                    echo " selected";
                                                                echo ">" . $name . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>    
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="description" placeholder="Описание" <?php if (isset($search_desc)) echo 'value="' . $search_desc . '"' ?> />
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="madeOf" placeholder="Состав" <?php if (isset($search_madeOf)) echo 'value="' . $search_madeOf . '"' ?> />
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="howTo" placeholder="Способ применения" <?php if (isset($search_howTo)) echo 'value="' . $search_howTo . '"' ?> />
                                                </div>
                                                <button type="submit" class="btn orange button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn orange button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                        <!-- / search box -->             
                </div>
            </div>
        </div>
        <!-- / header bottom  -->
    </header>
    <!-- / header section -->

    <!-- menu -->
    <section id="menu">
        <div class="container">
            <div class="navbar navbar-default" role="navigation">
                <button type="button" class="navbar-toggle left" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Показать меню</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>          
                <div class="navbar-collapse collapse">
                    <!-- Left nav -->
                    <ul class="nav navbar-nav" itemscope itemtype="http://www.schema.org/SiteNavigationElement">
                        <li itemprop="name"><a itemprop="url" href="/catalog/sc">Каталог<span class="caret"></a>
                            <ul class="dropdown-menu">
                                <?php 
                                foreach ($this->registry['supercats'] as $sc) {
                                ?>
                                    <li itemprop="name">
                                        <a itemprop="url" href="/catalog/sc/<?php echo $sc->url; ?>">
                                            <?php echo $sc->name; ?>
                                        </a>
                                    </li>        
                                <?php        
                                } 
                                ?>  
                            </ul>
                        </li>
                        <li itemprop="name"><a itemprop="url" href="/catalog/type?id=3">Для мужчин</a></li>
                        <li itemprop="name"><a itemprop="url" href="/catalog/type?id=2">Для детей</a></li>
                        <li itemprop="name"><a itemprop="url" href="/catalog/firm">Бренды<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php 
                                foreach ($this->registry['firms'] as $id => $firm) {
                                ?>
                                    <li itemprop="name">
                                        <a itemprop="url" href="/catalog/firm/<?php echo $firm->url; ?>">
                                            <?php echo $firm->name; ?>
                                        </a>
                                    </li>        
                                <?php        
                                } 
                                ?>  
                            </ul>
                        </li>
                        <li itemprop="name"><a itemprop="url" href="/actions">Акции<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li itemprop="name">
                                    <a itemprop="url" href="/actions/bestbefore">
                                        Истекающие сроки
                                    </a>
                                </li>        
                                <li itemprop="name">
                                    <a itemprop="url" href="/actions/discounts">
                                        Скидки
                                    </a>
                                </li>        
                            </ul>
                        </li>
                        <li itemprop="name"><a itemprop="url" href="/common/bonus">Бонусы</a></li>
                        <li itemprop="name"><a itemprop="url" href="/news">Новости</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- / menu -->
    
    <?php
    if ($pagePath) {
    ?>
        <a id="path" class="green button" href="<?php echo $pagePath ?>" title="Назад к списку товаров"><i class="fa fa-chevron-left"></i></a>
    <?php
    }
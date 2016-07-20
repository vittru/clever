<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">    
    <title>Клевер экомаркет</title>
    
    <link rel="icon" href="/images/icon.png">
    
    <link href="/css/search.css" rel="stylesheet">
    
    <!-- Font awesome -->
    <link href="/css/font-awesome.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="/css/bootstrap.css" rel="stylesheet">   
    <!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link href="/css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
    <!-- Product view slider -->
    <link rel="stylesheet" type="text/css" href="/css/jquery.simpleLens.css">    
    <!-- slick slider -->
    <link rel="stylesheet" type="text/css" href="/css/slick.css">
    <!-- price picker slider -->
    <link rel="stylesheet" type="text/css" href="/css/nouislider.css">
    <!-- Theme color -->
    <link id="switcher" href="/css/theme-color/green-theme.css" rel="stylesheet">
    <!-- <link id="switcher" href="css/theme-color/bridge-theme.css" rel="stylesheet"> -->
    <!-- Top Slider CSS -->
    <link href="/css/sequence-theme.modern-slide-in.css" rel="stylesheet" media="all">

    <!-- Main style sheet -->
    <link href="/css/style.css" rel="stylesheet">    

    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  

  </head>
  <body> 
   <!-- wpf loader Two -->
    <div id="wpf-loader-two">          
      <div class="wpf-loader-two-inner">
        <span>Загрузка</span>
      </div>
    </div> 
    <!-- / wpf loader Two -->       
  <!-- SCROLL TOP BUTTON -->
    <a class="scrollToTop" href="#"><i class="fa fa-chevron-up"></i></a>
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
                <div class="aa-header-top-left">
                    <a class="btn" href="/about" type="button" id="about">
                      О нас
                    </a>
                </div>
                <div class="aa-header-top-left">
                    <a class="btn" href="/common/delivery" type="button" id="delivery">
                       Доставка
                    </a>
                </div>
                <div class="aa-header-top-left">
                    <a class="btn" href="/common/payment" type="button" id="payment">
                       Оплата
                    </a>
                </div>
                <div class="aa-header-top-left">
                    <a class="btn" href="/contacts" type="button" id="contacts">
                       Контакты
                    </a>
                </div>

                <!-- start cellphone -->
                <div class="cellphone hidden-xs">
                  <p><span class="fa fa-phone"></span>+7 (927) 658-27-15</p>
                </div>
                <!-- / cellphone -->
              </div>
              <!-- / header top left -->
              <div class="aa-header-top-right">
                <ul class="aa-head-top-nav-right">
                  <?php
                  if ($this->registry['userName']) {
                  ?>
                  <li><a href="/account">Добро пожаловать <?php echo $this->registry['userName']  ?>!</a></li>
                  <?php
                  } else {
                  ?>
                  <li><a href="" data-toggle="modal" data-target="#login-modal">Войти/Зарегистрироваться</a></li>
                  <?php
                  }
                  ?>
                  <!--li class="hidden-xs"><a href="cart.html">Корзина</a></li-->
                  <li class="hidden-xs"><a href="/orders">Отследить заказ</a></li>
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
                <!-- Text based logo -->
                <a href="/index.php">
                  <span class="fa fa-shopping-cart"></span>
                  <p><strong>Клевер</strong> <span>магазин натуральной косметики</span></p>
                </a>
                <!-- img based logo -->
                <!-- a href="/index.php"><img src="images/design/logo.jpg" alt="Экомаркет Клевер"></a -->
              </div>
              <!-- / logo  -->
               <!-- cart box -->
              <div class="aa-cartbox">
                <a class="aa-cart-link" href="/basket">
                  <span class="fa fa-shopping-basket"></span>
                  <span class="aa-cart-title">Корзина</span>
                  <span class="aa-cart-notify"><?php echo count($this->registry['basket'])+1; ?></span>
                </a>
                <div class="aa-cartbox-summary">
                  <ul>
                    <li>
                        <img class="aa-cartbox-img" src="/images/goods/present.jpg" alt="Подарок">
                      <div class="aa-cartbox-info">
                        <h4>Подарок</h4>
                        <!--p>0&#x20bd;</p-->
                      </div>
                    </li>
                    <?php
                    $total = 0;
                    foreach ($this->registry['basket'] as $basketItem) {
                        $good = $this->registry['goods'][$basketItem->goodId];
                        $size = $good->sizes[$basketItem->sizeId];
                        $price = $size->getPrice($good->sale);
                        $total = $total + $basketItem->quantity * $price;
                        ?>
                        <li>
                          <a class="aa-cartbox-img" href="/showgood?id=<?php echo $good->id ?>"><img src="<?php echo $good->getImage() ?>" alt="<?php echo $good->name ?>"></a>
                          <div class="aa-cartbox-info">
                            <h4><?php echo $good->name ?> <?php echo $size->size ?></h4>
                            <p><?php echo $basketItem->quantity ?> x <?php echo $size->getWebPrice($good->sale) ?></p>
                          </div>
                          <a class="aa-remove-product" href="#"><span class="fa fa-times"></span></a>
                        </li>
                        <?php
                    }
                    ?>
                    <li>
                      <span class="aa-cartbox-total-title">
                        Всего покупок
                      </span>
                      <span class="aa-cartbox-total-price">
                        <?php echo $total ?> руб.
                      </span>
                    </li>
                  </ul>
                  <?php if (count($this->registry['basket']) > 0) { ?>  
                  <a class="aa-cartbox-checkout aa-primary-btn" href="/buy">Купить</a>
                  <?php } ?>
                </div>
              </div>
              <!-- / cart box -->
              <!-- search box -->
            <div class="input-group aa-search-box" id="adv-search">
                <input type="text" class="form-control" placeholder="Поиск по каталогу" />
                <div class="input-group-btn">
                    <div class="btn-group" role="group">
                        <div class="dropdown dropdown-lg">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                <form class="form-horizontal" role="form" action="/search">
                                  <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Производитель:</label>
                                        <select class="form-control" name="firm">
                                            <option value="0" selected></option>
                                            <?php
                                            foreach($this->registry['firms'] as $id=>$name) {
                                                echo "<option value=".$id.">".$name."</option>";
                                            }
                                            ?>
                                        </select>
                                      </div>
                                      <div class="form-group col-md-6">
                                        <label for="category">Категория:</label>
                                        <select class="form-control" name="category">
                                            <option value="0" selected></option>
                                            <?php
                                            foreach($this->registry['categories'] as $id=>$name) {
                                                echo "<option value=".$id.">".$name."</option>";
                                            }
                                            ?>
                                        </select>
                                      </div>
                                  </div>    
                                  <div class="row">  
                                    <div class="form-group col-md-6">
                                      <label for="problem">Проблема:</label>
                                      <select class="form-control" name="problem">
                                        <option value="0" selected></option>
                                        <?php
                                        foreach($this->registry['problems'] as $id=>$name) {
                                            echo "<option value=".$id.">".$name."</option>";
                                        }
                                        ?>
                                      </select>
                                    </div>
                                    <div class="form-group col-md-6"> 
                                      <label for="effect">Эффект:</label>
                                      <select class="form-control" name="effect">
                                        <option value="0" selected></option>
                                        <?php
                                        foreach($this->registry['effects'] as $id=>$name) {
                                            echo "<option value=".$id.">".$name."</option>";
                                        }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="row">  
                                  <div class="form-group col-md-6">
                                    <label for="skintype">Тип кожи:</label>
                                    <select class="form-control" name="skintype">
                                        <option value="0" selected></option>
                                        <?php
                                        foreach($this->registry['skintypes'] as $id=>$name) {
                                            echo "<option value=".$id.">".$name."</option>";
                                        }
                                        ?>
                                    </select>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="hairtype">Тип волос:</label>
                                    <select class="form-control" name="hairtype">
                                        <option value="0" selected></option>
                                        <?php
                                        foreach($this->registry['hairtypes'] as $id=>$name) {
                                            echo "<option value=".$id.">".$name."</option>";
                                        }
                                        ?>
                                    </select>
                                  </div>
                                  </div>    
                                  <div class="form-group">
                                    <label for="description">Описание:</label>
                                    <input class="form-control" type="text" name="description" />
                                  </div>
                                  <div class="form-group">
                                    <label for="description">Состав:</label>
                                    <input class="form-control" type="text" name="madeOf" />
                                  </div>
                                  <div class="form-group">
                                    <label for="description">Применение:</label>
                                    <input class="form-control" type="text" name="howTo" />
                                  </div>
                                  <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                </form>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    </div>
                </div>
            </div>
          </div>
              <!-- / search box -->             
            </div>
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
                <li><a href="/">Каталог</a></li>
                <li><a href="/catalog/firm">Бренды<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <?php foreach ($this->registry['firms'] as $key => $value) {
                          ?>
                          <li><a href="/catalog/firm?id=<?php echo $key; ?>">
                          <?php
                          echo $value;
                          ?>
                              </a>
                          </li>        
                          <?php        
                      } ?>  
                    </ul>
                </li>
                <li><a href="/actions">Акции</a>
                </li>
                <li><a href="/additional">Прочее</a>
                </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>       
    </div>
  </section>
  <!-- / menu -->

<?php
include 'header.php';

$bannersdir='images/banners';

$banners = array();
$dir = new DirectoryIterator($bannersdir);
foreach ($dir as $fileinfo) {  
    if (!$fileinfo->isDot()) { 
        $banners[$fileinfo->getMTime()] = $fileinfo->getFilename();
    }    
}

krsort($banners);

//$banners = new FilesystemIterator($bannersdir);
if (sizeof($banners) > 0) {
?>

<!-- Start slider -->
<div id="aa-slider" class="hidden-xs hidden-sm">
    <div class="aa-slider-area">
        <div id="sequence" class="seq">
            <div class="seq-screen">
                <ul <?php if (sizeof($banners) > 1) echo 'class="seq-canvas"' ?>>
                    <?php
                    //$dir = new DirectoryIterator($bannersdir);
                    $ind = 1;
                    foreach ($banners as $date=>$banner) {
                        $newsId = filter_var($banner, FILTER_SANITIZE_NUMBER_INT); 
                        $newsItem = $this->registry['model']->getNewsItem($newsId);
                        ?>  
                            <li <?php if ($ind == 1) echo 'class="seq-in"' ?>>
                                <div class="seq-model">
                                    <?php
                                    if ($newsItem->bannerlink) {
                                        if (substr($newsItem->bannerlink, strlen($newsItem->bannerlink) - 8) == '/actions') {
                                            $link = $newsItem->bannerlink . '#news' . $newsId;
                                        } else {
                                            $link = $newsItem->bannerlink;
                                        }
                                        echo '<a href="' . $link . '">';
                                    }    
                                    ?>
                                    <img data-seq src="<?php echo '/'.$bannersdir.'/'.$banner ?>" alt="<?php $banner ?>" />
                                    <?php
                                    if ($newsItem->bannerlink) {
                                        echo "</a>";
                                    }
                                    ?>
                                </div>
                            </li>
                        <?php
                        $ind++;
                    }
                    ?>
                </ul>
            </div>
            <!-- slider navigation btn -->
            <fieldset class="seq-nav" aria-controls="sequence" aria-label="Slider buttons">
                <a class="seq-prev" aria-label="Previous"><span class="fa fa-angle-left"></span></a>
                <a class="seq-next" aria-label="Next"><span class="fa fa-angle-right"></span></a>
            </fieldset>
        </div>
    </div>
</div>
<?php
}
?>
  
<section id="aa-product">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="center">Популярные товары</h2>
                <ul class="aa-product-catg">
                    <?php
                    foreach($pgoods as $good) {
                        $good->showInCatalog(false, 3);
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section> 
<section class="aa-text">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="center">Магазин натуральной (ЭКО) косметики в Самаре</h1>
                <p>Натуральная косметика способна преобразить Вашу внешность и при этом оказать положительное влияние на здоровье. Органическая косметика обладает рядом преимуществ в отличии от стандартной современной косметики, представленной на полках магазинов.</p>
                <ul>
                    <li><b>Компоненты натуральной косметики знакомы нашей коже, а значит – организм легче воспринимает экосредства.</b> При использовании природной (эко) косметики не наступает эффекта привыкания. Эко косметика не скрывает недостатки под слоем крема, а помогает коже бороться с причинами.</li>
                    <li><b>Косметика из природных веществ безопасна!</b> В составе отсутствуют химические добавки, консерванты, искусственно продлевающие сроки годности средств, синтетические отдушки. Фитокосметика свободна от силиконов, сульфатов и прочих негативно влияющих на здоровье и красоту добавок. </li>
                    <li><b>При покупке натуральной косметики Вы платите за состав, а не за бренд.</b> При этом производители уделяют особое внимание качеству ингредиентов. При изготовлении используются только цветочные и фруктовые экстракты, масла, витамины - источники питательных веществ для здоровой кожи.   Не смотря на это сама эко косметика доступна по цене, в сравнении с аналогичными зарубежными товарами.</li>
                    <li><b>Педиатры рекомендуют применять органическую косметику в уходе за нежной детской кожей.</b> Экологически чистые уходовые средства  помогают организму, нейтрализуя воздействие неблагоприятных факторов окружающей среды. Сила природы, заключенная в формулу каждого косметического эко продукта, способна разительно омолодить кожу, избавить от воспалений и акне, подтянуть контуры лица и совершить еще массу чудес, на которые не способны даже широко разрекламированные средства известных брендов. </li>
                </ul>
                <p>Заботясь о себе и близких, делайте выбор в пользу натуральности!</p>
                <h2>Преимущества покупок в интернет-магазине натуральных товаров Клевер</h2>
                <ul>
                    <li><b>В наличии 677 видов косметических средств и товаров для дома российских производителей.</b> Только 100% натуральные ингредиенты содержатся в продукции магазина.</li>
                    <li><b>Экомаркет  Клевер - официальный представитель брендов</b> Мастерской Олеси Мустаевой, МиКо, БиоБьюти и др. и предлагаем только сертифицированную продукцию. Мы гарантируем качество экологических товаров.</li>
                    <li><b>Доставка по Самаре в день заказа!</b> Готовы доставить Ваш заказ в течение дня или в другое подходящее для Вас время. Заказы на сумму больше 700<?php echo currency; ?>  доставляем по Самаре бесплатно!</li>
                    <li><b>Удобно и быстро оплачивать</b> - на сайте, наличными при получении заказа или переводом картой. Способ оплаты выбираете Вы, а  мы предоставляем печатные или электронные чеки. Юридическим лицам выставляем счет для безналичной оплаты перечислением на счет ООО “Клевер”.</li>
                    <li><b>В экомаркете действуют акции, скидки до 50% и розыгрыши.</b> Подпишитесь на рассылку и узнайте первыми о новых распродажах.</li>
                    <li><b>Эксперты интернет-магазина - визажист, косметолог и парикмахер, дают советы и консультации по уходу за собой.</b> В ВК, Инстаграм, Viber и другими способами связи помогаем с выбором необходимых Вам экологических товаров.</li>
                    <li><b>Мы дорожим Вашим доверием и благодарим Вас подарком в каждом заказе!</b></li>
                </ul>
            </div>    
        </div>
    </div>
</section>  

<section id="aa-reviews">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="center">Отзывы наших клиентов</h2>
                <div id="slideCarousel" class="carousel slide">
                    <div class="carousel-inner">
                    <?php
                    $active = false;
                    foreach ($reviews as $review) {
                    ?>                        
                        <div class="item <?php if (!$active) {echo "active"; $active = true; } ?> bonus-item">
                            <div class="aa-post-date">
                                <?php echo $review['date'] ?>
                            </div>
                            <?php
                            if ($review['clovers']) {
                            ?>
                            <span class="good-rating" data-toggle="tooltip" title="Оценка товара: <?php echo number_format($review['clovers'],2) ?>">
                                <?php
                                    for ($i = 1; $i <= $review['clovers']; $i++) {
                                        echo '<span class="orange-clover"></span>';
                                    }
                                    for ($i = $review['clovers'] + 1; $i <= 5; $i++) {
                                        echo '<span class="grey-clover"></span>';
                                    }
                                ?>
                                </span>
                            <?php
                            }
                            ?>
                            <div class="aa-post-author">
                                <?php if ($review['author']) echo '<b>Автор:</b> ' . $review['author']; ?>
                            </div>
                            <div>
                                <?php 
                                $text = $review['text'];
                                foreach (array("\r", "\n", "\r\n", "\n\r") as $token) {
                                    $text = str_replace($token, "</p><p>",  $text);
                                }
                                echo "<p>" . $text . "</p>";
                                ?>
                            </div>
                            <?php
                            if ($isadmin) {
                            ?>
                            <div>
                                <div class="green button review-button editReview" data-toggle="modal" data-target="#review" data-review="<?php echo $review['id']?>" data-clovers="<?php echo $review['clovers']?>" data-author="<?php echo $review['author']?>" data-text="<?php echo $review['text']?>" data-date="<?php echo $review['date'] ?>">Редактировать</div>                                
                                <div class="orange button review-button deleteReview" data-review="<?php echo $review['id']?>">Удалить</div>                                
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                    </div>
                    <a class="left carousel-control green button" href="#slideCarousel" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
                    <a class="right carousel-control green button" href="#slideCarousel" data-slide="next"><i class="fa fa-chevron-right"></i></a>
                </div>
                <div class="green button review-button center" id="addReview" data-toggle="modal" data-target="#review">Добавить отзыв/оценку</div>
            </div>
        </div>
    </div>
</section>

<section id="aa-client-brand">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="center">Наши бренды</h2>
                <div class="aa-client-brand-area">
                    <ul class="aa-client-brand-slider">
                        <?php 
                        foreach ($firms as $id=>$firm) {
                        ?>
                            <li><a href="/catalog/firm/<?php echo $firm->url; ?>"><img src="/images/firm/firm<?php echo $id; ?>.png" alt="<?php echo $firm->name; ?>" title="Натуральные средства <?php echo $firm->name ?>"></a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (!$user->spam) {
    include 'subscribe.php';
} ?>
  
<section id="aa-support">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4 col-sm-4 col-xs-12 aa-support-single">
                    <span class="fa fa-leaf"></span>
                    <h2>Качество</h2>
                    <P>Всегда свежая косметика от производителя.</P>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 aa-support-single">
                    <span class="fa fa-truck"></span>
                    <h2>Доставка</h2>
                    <P>Где бы вы ни были в России, мы сможем доставить товар.</P>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 aa-support-single">
                    <span class="fa fa-percent"></span>
                    <h2>Скидки</h2>
                    <P>Разнообразные акции для экономных покупок.</P>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="/js/sequence.js"></script>
<script src="/js/sequence-theme.modern-slide-in.js"></script>  
<?php
include 'footer.php';
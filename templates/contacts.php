<?php
include 'header.php';
?>

<!-- start contact section -->
<section id="aa-contact">
    <div class="container">
        <div class="row" id="aa-text">
            <div class="col-md-12">
                <div class="aa-contact-area">
                    <div class="aa-contact-address">
                        <div class="row">
                            <div class="col-md-12">
                                <h1>Наши контакты</h1>
                                <h2>Посмотреть и приобрести наши товары можно по следующим адресам в Самаре</h3>
                                <table class="table">
                                    <tr>
                                        <td>
                                            <p><b>Салон красоты "Каролина"</b></p>
                                            <p><b>ул. Стара-Загора, д.168</b></p>
                                            <div class="map"><script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=X_vOb2NXN7WVSnIiUtq5RbhTy3EdzSa4&amp;width=320&amp;height=240&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script></div>
                                            <p class="worktime">ежедневно с 10.00 до 20.00</p>
                                            <p class="phone">331-14-36, 331-14-37</p>
                                        </td>
                                        <td>
                                            <p><b>Салон красоты</b></p>
                                            <p><b>ул. Георгия Димитрова, д.112</b></p>
                                            <div class="map"><script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=GrArh56-A8ES1kTZdADZ7tgWcLvkOgSq&amp;width=320&amp;height=240&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script></div>
                                            <p  class="worktime">ежедневно с 10.00 до 21.00</p>
                                            <p class="phone">8-987-914-30-77</p>
                                        </td>
                                    </tr>
                                    <tr><td colspan="2"></td></tr>
                                </table>
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-md-8">
                                <div class="aa-contact-address-left">
                                    <h2>Задайте нам вопрос</h2>
                                    <form class="comments-form contact-form" action="" id="question-form" novalidate>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">                        
                                                    <input type="text" placeholder="Имя" class="form-control" id="question-name"
                                                    value="<?php echo $user->name; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">                        
                                                    <input type="email" placeholder="Почта" class="form-control" id="question-email"
                                                    value="<?php echo $user->email;?>">
                                                </div>
                                            </div>
                                        </div>   
                                        <div class="row">
                                            <div class="col-md-10">  
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" placeholder="Вопрос" id="question-text"></textarea>
                                                </div>
                                                <button class="aa-secondary-btn">Задать</button>
                                                <div id="question-error" display="none"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="aa-contact-address-right">
                                    <address>
                                        <h2>Клевер</h2>
                                        <h5>МАГАЗИН НАТУРАЛЬНОЙ КОСМЕТИКИ</h5>
                                        <!--p><span class="fa fa-home"></span>443011, Самара</p>
                                        <p><span class="fa fa-home"></span>ул. Ново-Садовая, 271</p-->
                                        <p><span class="fa fa-phone"></span>+7-996-725-00-61</p>
                                        <p><span class="fa fa-phone"></span>+7-996-725-00-62</p>
                                        <p><span class="fa fa-phone"></span>+7-996-730-46-22</p>
                                        <p><span class="fa fa-envelope"></span>clever@clubclever.ru</p>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (!$user->spam) {?>
<!-- Subscribe section -->
<section id="aa-subscribe">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-subscribe-area">
                    <h3>Подпишитесь на нашу рассылку </h3>
                    <p>Это позволит Вам первыми узнавать обо всех наших акциях и новинках!</p>
                    <form action="" class="aa-subscribe-form" id="subscribe-form" novalidate>
                        <input type="email" name="" id="subscribe-email" placeholder="Ваша почта" value="<?php echo $user->email;?>">
                        <input type="submit" value="ОК">
                    </form>
                    <div id="subscribe-error" display="none"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- / Subscribe section -->
<?php } ?>
  
<?php
include 'footer.php';
?>

<!-- subscribe js -->
<script src="/js/subscribe.js"></script>
<script src="/js/question.js"></script>

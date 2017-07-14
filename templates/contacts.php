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
                                <h2>Посмотреть и приобрести наши товары можно по следующим адресам в Самаре</h2>
                                <div class="row" style="display: flex">
                                    <div class="col-md-6 branch">
                                        <p><b>Студия красоты Аллы Пелевиной</b></p>
                                        <p><b>ул. Ново-Садовая, 271</b></p>
                                        <div class="map"><script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=3Z04yabmOvp2FZ3pW8QyO_fTbB6Y_MFy&amp;width=320&amp;height=240&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script></div>
                                        <p class="worktime">в будни с 10.00 до 20.00</p>
                                        <p class="worktime">по выходным с 10.00 до 18.00</p>
                                    </div>    
                                    <div class="col-md-6 branch">
                                        <p><b>Салон красоты "Каролина"</b></p>
                                        <p><b>ул. Стара-Загора, 168</b></p>
                                        <div class="map"><script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=X_vOb2NXN7WVSnIiUtq5RbhTy3EdzSa4&amp;width=320&amp;height=240&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script></div>
                                        <p class="worktime">ежедневно с 10.00 до 20.00</p>
                                        <p></p>
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="col-md-6 branch">
                                        <p><b>Салон красоты</b></p>
                                        <p><b>ул. Георгия Димитрова, 112</b></p>
                                        <div class="map"><script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=GrArh56-A8ES1kTZdADZ7tgWcLvkOgSq&amp;width=320&amp;height=240&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script></div>
                                        <p class="worktime">ежедневно с 10.00 до 21.00</p>
                                        <p></p>
                                    </div>    
                                </div>
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-md-8">
                                <div class="aa-question">
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
                                                    <input type="email" placeholder="Почта*" class="form-control" id="question-email"
                                                    value="<?php echo $user->email;?>">
                                                </div>
                                            </div>
                                        </div>   
                                        <div class="row">
                                            <div class="col-md-10">  
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" placeholder="Вопрос*" id="question-text"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <button class="green-button" onclick="yaCounter44412517.reachGoal('VOPROS'); return true;">Задать</button>
                                            </div>    
                                            <div id="question-error" class="col-md-8 error" hidden></div>
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
                                        <p><span class="fa fa-envelope"></span><?php echo $this->registry['mainemail'] ?></p>
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

<?php if (!$user->spam) {
    include 'subscribe.php';
}

include 'footer.php';
?>

<script src="/js/subscribe.js"></script>
<script src="/js/question.js"></script>

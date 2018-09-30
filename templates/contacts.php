<?php
include 'header.php';
?>

<!-- start contact section -->
<section id="aa-contact">
    <div class="container">
        <div class="row" id="aa-text" itemscope itemtype="http://schema.org/Organization">
            <div class="col-md-12">
                <div class="aa-contact-area">
                    <div class="aa-contact-address">
                        <div class="row">
                            <div class="col-md-12">
                                <h1>Наши контакты</h1>
                                <h2>Посмотреть и приобрести наши товары можно по следующим адресам в Самаре</h2>
                                <div class="row bonus-row">
                                    <div class="col-md-6 branch">
                                        <p></p>
                                        <p itemprop="streetAddress"><b>ул. Ново-Садовая, 271</b></p>
                                        <div class="map"><script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=3Z04yabmOvp2FZ3pW8QyO_fTbB6Y_MFy&amp;width=320&amp;height=240&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script></div>
                                        <p><span class="fa fa-clock-o"></span>в будни с 10.00 до 20.00</p>
                                        <p><span class="fa fa-clock-o"></span>по выходным с 10.00 до 18.00</p>
                                    </div>    
                                    <div class="col-md-6 branch">
                                        <p><b>Салон красоты "Красивые люди"</b></p>
                                        <p itemprop="streetAddress"><b>ул. Георгия Димитрова, 112</b></p>
                                        <div class="map"><script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=GrArh56-A8ES1kTZdADZ7tgWcLvkOgSq&amp;width=320&amp;height=240&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script></div>
                                        <p><span class="fa fa-clock-o"></span>ежедневно с 10.00 до 21.00</p>
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
                                        <h2 itemprop="name">Клевер</h2>
                                        <h5>МАГАЗИН НАТУРАЛЬНОЙ КОСМЕТИКИ</h5>
                                        <p>ООО "Клевер"</p>
                                        <p>ИНН 6315011857</p>
                                        <p><span class="fa fa-phone"></span><span class="ya-phone" itemprop="telephone">8 (846) 252 39 11</span></p>
                                        <p><span class="fa fa-envelope"></span><a onclick="yaCounter44412517.reachGoal('SEND_EMAIL'); return true;" href="mailto: <?php echo $this->registry['mainemail'] ?>" itemprop="email"><?php echo $this->registry['mainemail'] ?></a></p>
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

<script src="/js/question.min.js"></script>

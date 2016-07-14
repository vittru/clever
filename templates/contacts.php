<?php
include 'header.php';
?>

<!-- start contact section -->
<section id="aa-contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-contact-area">
                    <div class="aa-contact-top">
                        <h2>Мы всегда рады помочь Вам.</h2>
                        <p>Найти нас очень просто</p>
                    </div>
                    <!-- contact map -->
                    <div class="aa-contact-map">
                        <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=3Z04yabmOvp2FZ3pW8QyO_fTbB6Y_MFy&width=100%&height=450&lang=ru_RU&sourceType=constructor&scroll=true"></script>
                    </div>
                    <!-- Contact address -->
                    <div class="aa-contact-address">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="aa-contact-address-left">
                                    <h4>Задайте нам вопрос</h4>
                                    <form class="comments-form contact-form" action="" id="question-form" novalidate>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">                        
                                                    <input type="text" placeholder="Имя" class="form-control" id="question-name"
                                                    value="<?php echo $this->registry['userName'];?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">                        
                                                    <input type="email" placeholder="Почта" class="form-control" id="question-email"
                                                    value="<?php echo $this->registry['userEmail'];?>">
                                                </div>
                                            </div>
                                        </div>                                      
                                        <div class="form-group">                        
                                            <textarea class="form-control" rows="3" placeholder="Вопрос" id="question-text"></textarea>
                                        </div>
                                        <button class="aa-secondary-btn">Задать</button>
                                        <div id="question-error" display="none"></div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="aa-contact-address-right">
                                    <address>
                                        <h4>Клевер</h4>
                                        <h5>МАГАЗИН НАТУРАЛЬНОЙ КОСМЕТИКИ</h5>
                                        <p><span class="fa fa-home"></span>443011, Самара</p>
                                        <p><span class="fa fa-home"></span>ул. Ново-Садовая, 271</p>
                                        <p><span class="fa fa-phone"></span>+7-927-658-27-15</p>
                                        <p><span class="fa fa-envelope"></span>Email: clever@clubclever.ru</p>
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

<?php if (!$this->registry['isSpam']) {?>
<!-- Subscribe section -->
<section id="aa-subscribe">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-subscribe-area">
                    <h3>Подпишитесь на нашу рассылку </h3>
                    <p>Это позволит Вам первыми узнавать обо всех наших акциях и новинках!</p>
                    <form action="" class="aa-subscribe-form" id="subscribe-form" novalidate>
                        <input type="email" name="" id="subscribe-email" placeholder="Ваша почта" value="<?php echo $this->registry['userEmail'];?>">
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

<footer id="aa-footer">
    <div class="aa-footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="aa-footer-top-area">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="aa-footer-widget">
                                    <div class="footer-header">Главное меню</div>
                                    <ul class="aa-footer-nav">
                                        <li><a href="/catalog/type">Каталог</a></li>
                                        <li><a href="/catalog/category/presents">Подарки</a></li>
                                        <li><a href="/catalog/firms">Бренды</a></li>
                                        <li><a href="/actions">Акции</a></li>
                                        <li><a href="/news">Новости</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="aa-footer-widget">
                                    <div class="aa-footer-widget">
                                        <div class="footer-header">Информация</div>
                                        <ul class="aa-footer-nav">
                                            <!--li><a href="/about">О нас</a></li-->
                                            <li><a href="/common/delivery">Доставка</a></li>
                                            <li><a href="/common/payment">Оплата</a></li>
                                            <li><a href="/common/moneyback">Возврат</a></li>
                                            <li><a href="/contacts">Контакты</a></li>
                                            <li><a href="/common/offer">Оферта</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="aa-footer-widget">
                                    <div class="aa-footer-widget">
                                        <div class="footer-header">Материалы</div>
                                        <ul class="aa-footer-nav">
                                            <li><a target="_blank" rel="nofollow" href="https://www.biobeauty.ru/">БиоБьюти</a></li>
                                            <li><a target="_blank" rel="nofollow" href="http://master-om.com/">Мастерская Олеси Мустаевой</a></li>
                                            <li><a target="_blank" rel="nofollow" href="http://www.mi-ko.org/">МиКо</a></li>
                                            <li><a rel="nofollow" href="/common/certs">Сертификаты</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="aa-footer-widget">
                                    <div class="aa-footer-widget">
                                        <div class="footer-header">Наши контакты</div>
                                        <address>
                                            <p><span class="fa fa-phone"></span>+7-996-725-00-61</p>
                                            <p><span class="fa fa-phone"></span>+7-996-725-00-62</p>
                                            <p><span class="fa fa-phone"></span>+7-996-730-46-22</p>
                                            <p><span class="fa fa-envelope"></span><?php echo $this->registry['mainemail'] ?></p>
                                        </address>
                                        <div class="aa-footer-social">
                                            <!--a target="_blank" href="http://facebook.com"><span class="fa fa-facebook"></span></a-->
                                            <a target="_blank" rel="nofollow" href="https://vk.com/clubcleverru"><span class="fa fa-vk"></span></a>
                                            <a target="_blank" rel="nofollow" href="http://www.instagram.com/clubclever.ru/"><span class="fa fa-instagram"></span></a>
                                            <a target="_blank" rel="nofollow" href="https://www.youtube.com/channel/UCZqTkI8X0KQGyINHpblqhfg"><span class="fa fa-youtube"></span></a>
                                        </div>
                                        <div><a href="http://seoprostor.ru" rel="nofollow" target="_blank">Продвижение сайта</a> - «SEO Простор»</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Login Modal -->  
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">                      
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 id="auth-header">Войти</h4>
                <form class="aa-login-form" action="" id="auth-form">
                    <input type="text" placeholder="Имя*" id="auth-name" class="nologin form-control" name="userName" maxlength="30">   
                    <input type="text" placeholder="Почта*" id="auth-email" name="userEmail" class="form-control" maxlength="40" value="<?php echo $user->email ?>">
                    <input type="text" placeholder="Телефон" id="auth-phone" name="userPhone" class="nologin form-control" maxlength="20" value="<?php echo $user->phone ?>">
                    <input type="password" placeholder="Пароль*" id="auth-password" name="userPassword" class="form-control" maxlength="30">
                    <input type="password" placeholder="Повторите пароль*" id="auth-confirm" class="nologin form-control" name="userConfirm" maxlength="30">
                    <input type="number" placeholder="Номер сертификата" id="auth-flyer" class="nologin form-control" name="userFlyer" maxlength="6">   
                    <label for="auth-spam" class="nologin"><input type="checkbox" id="auth-spam" name="isSpam"> Подписаться на рассылку? </label>
                    <div id="auth-error" class="error"></div>
                    <input type="hidden" id="auth-action" name="userAction">
                    <button class="aa-login-btn green-button" type="submit" id="auth-submit">ОК</button>
                    <div class="modal-footer">
                        <div class="aa-register-now"></div>
                    </div>
                </form>
            </div>                        
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>    

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="/js/bootstrap.js"></script>  
<script type="text/javascript" src="/js/jquery.smartmenus.js"></script>
<script type="text/javascript" src="/js/jquery.smartmenus.bootstrap.js"></script>  
<script type="text/javascript" src="/js/slick.js"></script>
<script src="/js/jquery.sumoselect.js"></script>
<script src="/js/jquery-editable-select.js"></script>
<script src="/js/custom.js"></script> 
<script src="/js/jquery.validate.js"></script>
<script src="/js/auth-form.js"></script>
<script src="/js/clubclever.js?<?php echo '20170701'//filemtime('/js/clubclever.js'); ?>"></script>
<!--script src="/js/clubclever.js"></script-->
<script src="/js/lightbox.js"></script> 

</body>
</html>


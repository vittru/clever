<footer id="aa-footer" class="left">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="footer-header">Главное меню</div>
                        <ul class="aa-footer-nav">
                            <li><a href="/catalog/sc">Каталог</a></li>
                            <li><a href="/catalog/firms">Бренды</a></li>
                            <li><a href="/actions">Акции</a></li>
                            <li><a href="/news">Новости</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-sm-6">
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
                    <div class="col-md-3 col-sm-6">
                        <div class="footer-header">Материалы</div>
                        <ul class="aa-footer-nav">
                            <li><a target="_blank" rel="nofollow" href="https://www.biobeauty.ru/">БиоБьюти</a></li>
                            <li><a target="_blank" rel="nofollow" href="http://master-om.com/">Мастерская Олеси Мустаевой</a></li>
                            <li><a target="_blank" rel="nofollow" href="http://www.mi-ko.org/">МиКо</a></li>
                            <li><a rel="nofollow" href="/common/certs">Сертификаты</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="footer-header">Наши контакты</div>
                        <address>
                            <p>ООО "Клевер"</p>
                            <p>ИНН 6315011857</p>
                            <p><span class="fa fa-phone"></span><span class="ya-phone"><?php echo phoneNumber ?></span></p>
                            <p><span class="fa fa-envelope"></span><a href="mailto:<?php echo $this->registry['mainemail'] ?>"><?php echo $this->registry['mainemail'] ?></a></p>
                        </address>
                        <div class="aa-footer-social">
                            <!--a target="_blank" href="http://facebook.com"><span class="fa fa-facebook"></span></a-->
                            <a target="_blank" rel="nofollow" href="https://vk.com/clubcleverru"><span class="fa fa-vk"></span></a>
                            <a target="_blank" rel="nofollow" href="http://www.instagram.com/clubclever.ru/"><span class="fa fa-instagram"></span></a>
                            <a target="_blank" rel="nofollow" href="https://www.youtube.com/channel/UCZqTkI8X0KQGyINHpblqhfg"><span class="fa fa-youtube"></span></a>
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
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 id="auth-header">Войти</h4>
            </div>
            <div class="modal-body">
                <form class="aa-login-form" action="" id="auth-form">
                    <input type="text" placeholder="Имя*" id="auth-name" class="nologin form-control" name="userName" maxlength="30">   
                    <input type="text" placeholder="Почта*" id="auth-email" name="userEmail" class="form-control" maxlength="40" value="<?php echo $user->email ?>">
                    <input type="text" placeholder="Телефон" id="auth-phone" name="userPhone" class="nologin form-control" maxlength="20" value="<?php echo $user->phone ?>">
                    <input type="text" onfocus="(this.type='date')" placeholder="Дата рождения" id="auth-birthday" name="userBirthday" class="nologin form-control" maxlength="20" value="<?php echo $user->birthday ?>">
                    <input type="password" placeholder="Пароль*" id="auth-password" name="userPassword" class="form-control" maxlength="30">
                    <input type="password" placeholder="Повторите пароль*" id="auth-confirm" class="nologin form-control" name="userConfirm" maxlength="30">
                    <input type="number" placeholder="Номер сертификата" id="auth-flyer" class="nologin form-control" name="userFlyer" maxlength="6">   
                    <label for="auth-spam" class="nologin"><input type="checkbox" id="auth-spam" name="isSpam"> Подписаться на рассылку? </label>
                    <div class="forget-password"><a id="forget-password" onclick="showPasswordForm()">Забыли пароль?</a></div>
                    <div id="auth-error" class="error"></div>
                    <input type="hidden" id="auth-action" name="userAction">
                    <button class="aa-login-btn green button" type="submit" id="auth-submit">ОК</button>
                </form>
            </div> 
            <div class="modal-footer">
                <div class="aa-register-now"></div>
            </div>    
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>  

<!-- Email Me Modal -->
<div class="modal fade" id="emailMe" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Сообщить о поступлении</h4>
            </div>
            <div class="modal-body">
                <input id="emailGoodId" hidden>
                <?php 
                if ($user->name) {
                ?>    
                    <div>Как Вам сообщить о поступлении товара?</div>
                    <div class="radio">
                        <label for="emailMeREmail"><input id="emailMeREmail" type="radio" name="emailMeRAddr" value="email" checked><?php echo $user->email ?></label>
                    </div>
                    <div class="radio">
                        <label for="emailMeRPhone"><input id="emailMeRPhone" type="radio" name="emailMeRAddr" value="phone">
                            <?php
                            if ($user->phone) {
                                echo $user->phone;
                            } else {
                                ?>
                                <input id="emailMePhone" type="text" placeholder="телефон" class="form-control" disabled>
                                <?php
                            }
                            ?>
                        </label>
                    </div>
                <?php    
                } else {
                ?>
                    <div>Оставьте свой контакт, и мы сообщим Вам, когда товар будет в наличии</div>
                    <input type="text" placeholder="email или телефон*" id="emailMeAddr" class="form-control">
                <?php
                }
                ?>
                <button type="button" class="green button" id="emailMeSubmit">Сообщить</button>
            </div>    
        </div>
    </div>
</div>   

<!-- Quick Order Modal -->
<div class="modal fade" id="quickOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Быстрый заказ</h4>
            </div>
            <div class="modal-body">
                <div id="quickOrderOrder">
                    <div class="row">
                        <div class="col-sm-6">
                            <img src="" id="quickOrderImage"/>
                        </div>
                        <div class="col-sm-6">
                            <h4 id="quickOrderGood"></h4>
                            <input id="quickOrderGoodId" name="quickOrderGoodId" hidden>
                        </div>    
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <input id="quickOrderSizeId1" name="quickOrderSizeId1" hidden>
                            <input id="quickOrderSizeSale1" hidden>
                            <div><span id="quickOrderSize1"></span>: <span id="quickOrderQuantity1"></span> x <span id="quickOrderPrice1"></span> <?php echo currency ?></div>
                            <input id="quickOrderSizeId2" name="quickOrderSizeId2" hidden>
                            <input id="quickOrderSizeSale2" hidden>
                            <div hidden><span id="quickOrderSize2"></span>: <span id="quickOrderQuantity2"></span> x <span id="quickOrderPrice2"></span> <?php echo currency ?></div>
                            <input id="quickOrderSizeId3" name="quickOrderSizeId3" hidden>
                            <input id="quickOrderSizeSale3" hidden>
                            <div hidden><span id="quickOrderSize3"></span>: <span id="quickOrderQuantity3"></span> x <span id="quickOrderPrice3"></span> <?php echo currency ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div>Стоимость заказа: <b><span id="quickOrderTotalPrice"></span> <?php echo currency ?></b></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div>Пожалуйста, укажите свои контакты, и наш менеджер свяжется с Вами по поводу доставки заказа.</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <input id="quickOrderEmail" type="text" name="quickOrderAddr" checked placeholder="Почта*" maxlength="40" <?php echo 'value="' . $user->email .'"' ?> >
                            <input id="quickOrderPhone" type="text" name="quickOrderPhone" placeholder="Телефон*" maxlength="20" <?php echo 'value="' . $user->phone . '"' ?>>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="quickOrderError" hidden class="error"></div>
                        </div>    
                    </div>    
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="button" class="green button" id="quickOrderSubmit">Заказать</button>
                        </div>    
                    </div>    
                </div>
                <div id="quickOrderComplete" hidden>
                    <h4>Номер вашего заказа: <span id="quickOrderId"></span></h4>
                    <p>Наш менеджер свяжется с Вами в ближайшее время, чтобы уточнить детали</p>
                    <p></p>
                    <p>Спасибо за шоппинг с нами.</p>
                    <h4>Ваш Клевер!</h4>
                    <button class="green button" data-dismiss="modal">Закрыть</button>
                </div>
            </div>    
        </div>
    </div>
</div>   

<!-- Review Modal -->
<div class="modal fade" id="review" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Отзыв</h4>
            </div>
            <div class="modal-body">
                <input id="reviewId" hidden value="">
                <div class="row">
                    <div class="col-sm-6">
                        <div>Ваша оценка:</div>
                        <div class="star-rating">
                            <input type="radio" id="5-clovers" class="clovers" name="rating" value="5" />
                            <label for="5-clovers" class="star" data-toggle="tooltip" title="Отличный"></label>
                            <input type="radio" id="4-clovers" class="clovers" name="rating" value="4" />
                            <label for="4-clovers" class="star" data-toggle="tooltip" title="Хороший"></label>
                            <input type="radio" id="3-clovers" class="clovers" name="rating" value="3" />
                            <label for="3-clovers" class="star" data-toggle="tooltip" title="Средний"></label>
                            <input type="radio" id="2-clovers" class="clovers" name="rating" value="2" />
                            <label for="2-clovers" class="star" data-toggle="tooltip" title="Так себе"></label>
                            <input type="radio" id="1-clovers" class="clovers" name="rating" value="1" />
                            <label for="1-clovers" class="star" data-toggle="tooltip" title="Плохой"></label>
                        </div>
                    </div>
                </div>    
                <div class="row">
                    <?php
                    if ($isadmin) {
                    ?>
                    <div class="col-sm-12">
                        <input id="reviewDate" type="date" placeholder="Дата" class="form-control" value="">
                        <script>
                            document.getElementById('reviewDate').valueAsDate = new Date();
                        </script>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="col-sm-12">
                        <input id="reviewAuthor" type="text" placeholder="Ваше имя" class="form-control" value="<?php echo $user->name ?>">
                    </div>
                </div>    
                <div class="row">
                    <div class="col-sm-12">
                        <textarea type="text" rows="3" placeholder="Отзыв" id="reviewText" class="form-control" value=""></textarea>
                    </div>
                </div>    
                <div class="row">
                    <div class="col-sm-12">
                        <div id="reviewError" class="error" hidden></div>
                    </div>
                </div>    
                <div class="row">
                    <div class="col-sm-12">
                        <button type="button" class="green button" id="reviewSubmit">Сохранить</button>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
</div>   



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>



<script src="/js/bootstrap.min.js"></script>  
<script type="text/javascript" src="/js/jquery.smartmenus.min.js"></script>
<script type="text/javascript" src="/js/jquery.smartmenus.bootstrap.min.js"></script>  
<script type="text/javascript" src="/js/slick.min.js"></script>
<script src="/js/jquery.sumoselect.min.js"></script>
<script src="/js/jquery-editable-select.js"></script>
<script src="/js/custom.min.js?20181101"></script> 
<script src="/js/jquery.validate.min.js"></script>
<script src="/js/auth-form.min.js?<?php echo '20171228' ?>"></script>
<script src="/js/clubclever.min.js?<?php echo '20190718' ?>"></script>
<script src="/js/lightbox.min.js"></script> 

</body>
</html>


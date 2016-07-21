
    <!-- footer -->  
  <footer id="aa-footer">
    <!-- footer bottom -->
    <div class="aa-footer-top">
     <div class="container">
        <div class="row">
        <div class="col-md-12">
          <div class="aa-footer-top-area">
            <div class="row">
              <div class="col-md-3 col-sm-6">
                <div class="aa-footer-widget">
                  <h3>Главное меню</h3>
                  <ul class="aa-footer-nav">
                    <li><a href="/">Каталог</a></li>
                    <li><a href="/catalog/firms">Бренды</a></li>
                    <li><a href="/actions">Акции</a></li>
                    <li><a href="/additional">Прочее</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="aa-footer-widget">
                  <div class="aa-footer-widget">
                    <h3>Информация</h3>
                    <ul class="aa-footer-nav">
                      <li><a href="/about">О нас</a></li>
                      <li><a href="/common/delivery">Доставка</a></li>
                      <li><a href="/common/payment">Оплата</a></li>
                      <li><a href="/common/moneyback">Возврат</a></li>
                      <li><a href="/contacts">Контакты</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="aa-footer-widget">
                  <div class="aa-footer-widget">
                    <h3>Ссылки</h3>
                    <ul class="aa-footer-nav">
                      <li><a target="_blank" href="http://master-om.com/">Мастерская Олеси Мустаевой</a></li>
                      <li><a target="_blank" href="https://www.biobeauty.ru/">БиоБьюти</a></li>
                      <li><a target="_blank" href="http://www.mi-ko.org/">МиКо</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="aa-footer-widget">
                  <div class="aa-footer-widget">
                    <h3>Наши контакты</h3>
                    <address>
                      <p> Самара, ул. Ново-Садовая, 271</p>
                      <p><span class="fa fa-phone"></span>+7 927-658-27-15</p>
                      <p><span class="fa fa-envelope"></span>clever@clubclever.ru</p>
                    </address>
                    <div class="aa-footer-social">
                      <a target="_blank" href="http://facebook.com"><span class="fa fa-facebook"></span></a>
                      <a target="_blank" href="http://vk.com"><span class="fa fa-vk"></span></a>
                      <a target="_blank" href="http://youtube.com"><span class="fa fa-youtube"></span></a>
                    </div>
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
  <!-- / footer -->
  
   <!-- Login Modal -->  
  <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">                      
        <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 id="auth-header">Войти</h4>
          <form class="aa-login-form" action="" id="auth-form">
            <!--label for="">Почта<span>*</span></label-->
            <input type="text" placeholder="Имя" id="auth-name" class="nologin" name="userName">   
            <input type="text" placeholder="Почта" id="auth-email" name="userEmail">
            <!--label for="">Пароль<span>*</span></label-->
            <input type="password" placeholder="Пароль" id="auth-password" name="userPassword">
            <input type="password" placeholder="Повторите пароль" id="auth-confirm" class="nologin" name="userConfirm">
            <label for="" class="nologin"><input type="checkbox" id="auth-spam" name="isSpam"> Подписаться на рассылку? </label>
            <div id="auth-error"></div>
            <input type="hidden" id="auth-action" name="userAction"></input>
            <button class="aa-browse-btn" type="submit" id="auth-submit">ОК</button>
            <!--label for="rememberme" class="rememberme"><input type="checkbox" id="rememberme"> Remember me </label-->
            <!--p class="aa-lost-password"><!--a href="#">Забыли пароль?</a></p-->
            <div class="modal-footer">
                <div class="aa-register-now"></div>
            </div>
          </form>
        </div>                        
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>    
   <!-- /Login Modal -->

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="/js/bootstrap.js"></script>  
  <!-- SmartMenus jQuery plugin -->
  <script type="text/javascript" src="/js/jquery.smartmenus.js"></script>
  <!-- SmartMenus jQuery Bootstrap Addon -->
  <script type="text/javascript" src="/js/jquery.smartmenus.bootstrap.js"></script>  
  <!-- To Slider JS -->
  <!--script src="js/sequence.js"></script>
  <script src="js/sequence-theme.modern-slide-in.js"></script-->  
  <!-- Product view slider -->
  <script type="text/javascript" src="/js/jquery.simpleGallery.js"></script>
  <script type="text/javascript" src="/js/jquery.simpleLens.js"></script>
  <!-- slick slider -->
  <script type="text/javascript" src="/js/slick.js"></script>
  <!-- Price picker slider -->
  <script type="text/javascript" src="/js/nouislider.js"></script>
  <!-- Custom js -->
  <script src="/js/custom.js"></script> 
  <script src="/js/jquery.validate.js"></script>
  <!-- auth-form js -->
  <script src="/js/auth-form.js"></script>
  <!-- clubclever js -->
  <script src="/js/clubclever.js"></script>

  </body>
</html>


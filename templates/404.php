<?php
    include 'header.php';
?>
  
<section id="aa-error">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-error-area">
                    <h2>404</h2>
                    <span>Извините! У нас нет запрашиваемой Вами страницы.</span>
                    <p>Уточните вашу ссылку или напишите нам <a class="email" href="mailto:<?php echo $this->registry['mainemail'] ?>"><?php echo $this->registry['mainemail'] ?></a></p>
                    <a href="/" class="green-button"> На главную</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    include 'footer.php';
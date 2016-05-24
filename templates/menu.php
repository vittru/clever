<?php
include 'auth.php';
?>
<div id='header'>
    <a href='index'>
        <div id='header_image'>
        </div>
    </a>
    <div id='header_menu'>
        <div id='header_welcome'><?php
            if ($userName != ''){
                ?>
            <div>Добро пожаловать <div class="link" id="profile"><?php echo $userName ?></div></div>
                <?php
            }else{
            ?>
            <div class ="link" id="register">Войти/Зарегистрироваться</div>
            <?php
            }
        ?></div>
        <div id='header_networks'>
            <a href='http://vk.com' target="blank">
                <img class="img_network" src='images/design/vk.jpg'/>
            </a>
            <a href='http://ok.ru' target='blank'>
                <img class="img_network" src='images/design/ok.png'/>
            </a>
            <a href='http://facebook.com' target='blank'>
                <img class="img_network" src='images/design/facebook.png'/>
            </a>
            <a href='http://instagram.com' target='blank'>
                <img class="img_network" src='images/design/instagram.png'/>
            </a>
        </div>
        <div class='line_left clear'>
            <div class='top_menu <?php if ($selmenu==1) echo "top_menu_current top_menu_active"; ?>'><a href="about"><div>О нас</div></a></div>
            <div class='top_menu <?php if ($selmenu==2) echo "top_menu_current top_menu_active"; ?>'><a href="news"><div>Новости</div></a></div>
            <div class='top_menu <?php if ($selmenu==3) echo "top_menu_current top_menu_active"; ?>'><a href="courses"><div>Занятия</div></a></div>
            <div class='top_menu <?php if ($selmenu==4) echo "top_menu_current top_menu_active"; ?>'><a href="interesting"><div>Интересное</div></a></div>
            <div class='top_menu <?php if ($selmenu==5) echo "top_menu_current top_menu_active"; ?>'><a href="contacts"><div>Контакты</div></a></div>
        </div>
    </div>
</div>
<script src="scripts/jquery-2.2.3.js" type="text/javascript"></script>
<script src="scripts/auth-form.js"></script>
<?php
if ($userName != '') {
    ?>
    <script src="scripts/profile.js" ></script>
    <?php 
} else{
    ?>
    <script src="scripts/register.js" ></script>
    <?php 
}
?>




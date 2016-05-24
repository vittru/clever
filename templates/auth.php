<?php

?>
  <div id="auth-form-container">
    <form id="auth-form" name="auth-form" novalidate method="post" action="register">
        <div id="auth-header"></div>
        <input class="auth-attribute nologin" placeholder="Имя" value="<?php echo $userName ?>" id="auth-name" type="text" name="userName" required></input>
        <input class="auth-attribute" placeholder="Почта" value="<?php echo $userEmail ?>" id="auth-email" type="text" name="userEmail" required></input>
        <input class="auth-attribute" placeholder="Пароль" value id="auth-password" type="password" name="userPassword"></input>
        <input class="auth-attribute nologin noprofile" placeholder="Подтвердите пароль" value id="auth-confirm" type="password" name="userConfirm"></input><br>
        <label class="auth-attribute checkbox nologin"><input class="auth-attribute" id="auth-client" type="checkbox" name="isClient" <?php if ($isClient == 1) echo "checked"; ?> ></input>Наш клиент?</label><br>
        <label class="auth-attribute checkbox nologin"><input class="auth-attribute" id="auth-spam" type="checkbox" name="isSpam" <?php if ($spam == 1) echo "checked"; ?> ></input>Подписаны на рассылку?</label><br>
        <div id="auth-error" class="error" display="none"></div>
        <input type="hidden" id="auth-action" name="userAction"></input>
        <input type="hidden" name="page" id="auth-page" value="<?php echo 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; ?>" ></input>
        <input type="submit" id="auth-submit" value="Ок">
        <input type="button" name="cancel" value="Отмена">
    </form>
  </div>


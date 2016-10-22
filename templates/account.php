<?php
include 'header.php';
?>
 
<section id="aa-myaccount">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-myaccount-area">  
                    <h1>Аккаунт</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="aa-myaccount-details">
                                <h2>Мои данные</h2>
                                <form action="" class="aa-login-form" id="auth-form">
                                    <label for="">Имя<span>*</span></label>
                                    <input type="text" placeholder="Имя" id="auth-name" class="form-control" name="userName" value="<?php echo $user->name ?>" maxlength="30">
                                    <label for="">Почта<span>*</span></label>
                                    <input type="text" placeholder="Почта" id="auth-email" name="userEmail" class="form-control" value="<?php echo $user->email ?>" maxlength="40">
                                    <label for="">Телефон</label>
                                    <input type="text" placeholder="Телефон" id="auth-phone" name="userPhone" class="form-control" value="<?php echo $user->phone ?>" maxlength="20">
                                    <label for="">Пароль<span>*</span></label>
                                    <input type="password" placeholder="Пароль" id="auth-password" name="userPassword" class="form-control" value="<?php echo $user->password ?>" maxlength="30">
                                    <label for="">Подтверждение пароля<span>*</span></label>
                                    <input type="password" placeholder="Подтверждение пароля" id="auth-confirm" class="nologin form-control" name="userConfirm" value="<?php echo $user->password ?>" maxlength="30">
                                    <label for="auth-spam"><input type="checkbox" id="auth-spam" name="isSpam" <?php if ($user->spam) echo "checked" ?>> Подписаться на рассылку? </label>
                                    <input type="hidden" id="auth-action" name="userAction" value="update">
                                    <div hidden id="auth-error" class="error"></div>
                                    <button type="submit" class="green-button">Изменить профиль</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="aa-myaccount-bonus">
                                <h2>Мои бонусы</h2>
                                <?php 
                                if ($user->bonus) {
                                ?>
                                    <p>На вашем счету сейчас бонусов: <?php echo $user->bonus; ?></p>
                                <?php 
                                } else {
                                ?>
                                    <p>У Вас пока нет бонусов. Оформите заказы, чтобы получить их.
                                <?php    
                                }
                                ?>
                            </div>
                            <div class="aa-myaccount-orders">
                                <h2>Мои заказы</h2>
                                <?php
                                if (sizeof($orders) > 0) {
                                ?>
                                    <table class="table">
                                        <tr>
                                            <th>Номер</th>
                                            <th>Дата</th>
                                            <th>Статус</th>
                                            <th></th>
                                        </tr>
                                        <?php
                                        foreach ($orders as $order) {
                                        ?>
                                        <tr>
                                            <td><?php echo $order->id?></td>
                                            <td><?php echo $order->date?></td>
                                            <td> <span class="dotted" data-toggle="tooltip" title="<?php echo $order->statusdesc; ?>"><?php echo $order->status?></span></td>
                                            <td><a class="green-button order-details" href="/account/orders?id=<?php echo $order->id ?>">Детали</a></td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                        <tr><td colspan="4"></td></tr>
                                    </table>
                                <?php
                                } else {
                                ?>
                                    <h4>У вас еще нет заказов на нашем сайте</h4>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <a href="/account/logout" id="logout" class="orange-button">Выйти</a>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'footer.php';
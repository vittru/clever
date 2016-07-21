<?php

include 'header.php';
?>
<section>
    <h2>Возврат товара</h2>
    <h3>Условия возврата</h3>
    <p>По любым вопросам, возникающим в связи с качеством представляемой нами продукцией, просьба связаться с <a href="/contacts">нами</a>. Напоминаем, что возврат товара ненадлежащего качества осуществляется в соответствии с ФЗ "О защите прав потребителей". Парфюмерно-косметические товары надлежащего качества возврату и обмену не подлежат, согласно Постановлению Правительства РФ от 19.01.1998 г. №55.</p>   
    <h3>Форма для возврата товара</h3>
    <p>Пожалуйста, заполните форму запроса на возврат товара.</p>   
    <form>
        <h4>Информация о заказе</h4>
        <div class="form-group">
            <label for="name">Ваше имя:</label>
            <input type="text" class="form-control" id="name" name="name" value='<?php if ($user->name) echo $user->name ?>'>
        </div> 
        <div class="form-group">
            <label for="email">Ваш e-mail:</label>
            <input type="text" class="form-control" id="email" name="email" value='<?php if ($user->email) echo $user->email ?>'>
        </div> 
        <div class="form-group">
            <label for="phone">Ваш телефон:</label>
            <input type="text" class="form-control" id="phone" name="phone" value='<?php if ($user->phone) echo $user->phone ?>'>
        </div> 
        <div class="form-group">
            <label for="order">Номер заказа:</label>
            <?php
            if ($user->orders) {
            ?>
                <select class="form-control" id="orderdate" name="orderdate">
                    <?php
                    foreach ($user->orders as $order) {
                        ?>
                        <option value="order<?php echo $order->id ?>"><?php echo $order->date ?></option>
                        <?php
                    }
                    ?>
                </select>
            <?php
            } else {
            ?>
                <input type="text" class="form-control" id="order" name="order" value=''>
            <?php
            }
            ?>
        </div>
        <div class="form-group">
            <label for="orderdate">Дата заказа:</label>
            <?php
            if ($user->orders) {
            ?>
                <select class="form-control" id="orderdate" name="orderdate">
                    <?php
                    foreach ($user->orders as $order) {
                        ?>
                        <option value="order<?php echo $order->id ?>"><?php echo $order->date ?></option>
                        <?php
                    }
                    ?>
                </select>
            <?php
            } else {
            ?>
                <input type="text" class="form-control" id="orderdate" name="orderdate" value=''>
            <?php
            }
            ?>
        </div>
        <h4>Информация о товаре и причины возврата</h4>
        <div class="form-group">
            <label for="good">Товар:</label>
            <?php
            if ($user->orders) {
            ?>
                <select class="form-control" id="good" name="good">
                    <?php
                    foreach ($user->orders as $order) {
                        ?>
                    <!--This should be corrected!!!!!!!-->
                        <option value="order<?php echo $order->id ?>"><?php echo $order->date ?></option>
                        <?php
                    }
                    ?>
                </select>
            <?php
            } else {
            ?>
                <input type="text" class="form-control" id="good" name="good" value=''>
            <?php
            }
            ?>
        </div>        
        <div class="form-group">
            <label for="goodcount">Количество:</label>
            <select class="form-control" id="goodcount" name="goodcount">
                <?php
                if ($user->orders) {
                    foreach ($user->orders as $order) {
                    ?>
                    <!--This should be corrected!!!!!!!-->
                        <option value="goodcount<?php echo $order->id ?>"><?php echo $order->date ?></option>
                    <?php
                    }
                } else {
                    ?>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="reason">Причина возврата:</label>
            <select class="form-control" id="reason" name="reason">
                <?php
                foreach ($this->registry['reasons'] as $id=>$reason) {
                ?>
                    <option value="<?php echo $id ?>"><?php echo $reason ?></option>
                <?php
                }
                ?>
            </select>
        </div>
    </form>
</section>    
<?php
include 'footer.php';


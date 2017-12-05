<?php

Class Controller_Mailout Extends Controller_Base {

    function index() {
        if ($this->registry['isadmin']) {
            //$this->registry['model']->logVisit(1000);
            //$this->registry['template']->set('emails', $this->registry['model']->getSpamEmails());
            $this->registry['template']->show('mailout');
        } else {
            $this->registry['template']->show('404');
        }
    }
    
    function send() {
        if ($this->registry['isadmin']) {
            $emails = $this->registry['model']->getSpamEmails();
            $topic = $_POST['header'];
            $message = $_POST['text'];
            foreach ($emails as $id => $to) {
                $this->registry['logger']->lwrite('Sending mail to ' . $to);
                //$this->sendMail($to, $topic, $message . '<p style="color: rgb(80, 0, 80); font-family: arial, sans-serif; font-size: 12.8px;"><span style="color: rgb(34, 34, 34); font-family: -apple-system, system-ui, Roboto, &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif; font-size: 13px;">Ваш&nbsp;<a href="http://ecomarketclever.ru" target="_blank">Экомаркет Клевер</a>.</span></p><p style="color: rgb(80, 0, 80); font-family: arial, sans-serif; font-size: 12.8px;"><span style="font-family: -apple-system, system-ui, Roboto, &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif; font-size: 13px;"><font color="#cec6ce">Вы получили это письмо, потому что подписаны на рассылку Экомаркета Клевер. <a href="http://ecomarketclever.ru/subscribe/stop?id='.$id.'" target="_blank">Отписаться от рассылки</a>.</font></span></p>');
            }
            header("LOCATION: /");
        } else {
            $this->registry['template']->show('404');
        }
    }
    
    function testEmail() {
        if ($this->registry['isadmin']) {
            $to = $_POST['email'];
            $topic = $_POST['header'];
            $message = $_POST['text'];
            $this->sendMail($to, $topic, $message . '<p style="color: rgb(80, 0, 80); font-family: arial, sans-serif; font-size: 12.8px;"><span style="color: rgb(34, 34, 34); font-family: -apple-system, system-ui, Roboto, &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif; font-size: 13px;">Ваш&nbsp;<a href="http://ecomarketclever.ru" target="_blank">Экомаркет Клевер</a>.</span></p><p style="color: rgb(80, 0, 80); font-family: arial, sans-serif; font-size: 12.8px;"><span style="font-family: -apple-system, system-ui, Roboto, &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif; font-size: 13px;"><font color="#cec6ce">Вы получили это письмо, потому что подписаны на рассылку Экомаркета Клевер. <a href="http://ecomarketclever.ru/subscribe/stop?id=' . $id . '" target="_blank">Отписаться от рассылки</a>.</font></span></p>');
            echo "Отправлено на " . $to;
        } else {
            $this->registry['template']->show('404');
        }
    }
}


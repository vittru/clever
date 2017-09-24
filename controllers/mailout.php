<?php

Class Controller_Mailout Extends Controller_Base {

    function index() {
        if ($this->registry['isadmin']) {
            //$this->registry['model']->logVisit(1000);
            $this->registry['template']->set('emails', $this->registry['model']->getSpamEmails());
            $this->registry['template']->show('mailout');
        } else 
            $this->registry['template']->show('404');
    }
    
    function send() {
        if ($this->registry['isadmin']) {
            $emails = $this->registry['model']->getSpamEmails();
            $topic = $_POST['header'];
            $message = $_POST['text'];
            foreach ($emails as $to) {
                $this->registry['logger']->lwrite('Sending mail to '.$to);
                //$this->sendMail($to, $topic, $message);
            }    
            header("LOCATION: /");
        } else 
            $this->registry['template']->show('404');            
        
    }
}


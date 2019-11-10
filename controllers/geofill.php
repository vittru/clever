<?php

Class Controller_Geofill Extends Controller_Base {

    function index() {
        if (isadmin) {
            $users = $this->registry['model']->getUsersWithoutGeo();
            foreach ($users as $id=>$ip) {
                $json = file_get_contents("http://freegeoip.net/json/" . $ip);
                $geo = json_decode($json, true);
                $this->registry['model']->updateGeoUser($id, $geo['country_name'], $geo['city']);
            }
        }    
        $this->registry['template']->show('404');
    }
}


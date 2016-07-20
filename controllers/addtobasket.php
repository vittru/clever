<?php

Class Controller_Addtobasket Extends Controller_Base {

    function index() {
        $data = json_decode($_POST['data'], true);
        $this->registry['logger']->lwrite("parsing data " . sizeof($data));
        foreach ($data as $d) {
            $basketItem = new BasketItem();
            $basketItem->goodid = $d['goodId'];
            $basketItem->quantity = $d['count'];
            $basketItem->sizeid = $d['sizeId'];
            push_array($this->registry['basket'], $basketItem);
        }
    }
}



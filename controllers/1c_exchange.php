<?php

Class Controller_1c_exchange Extends Controller_Base {
                    
    function index() {

        // Папка для хранения временных файлов синхронизации
        $dir = '/tmp/';
        // Обновлять все данные при каждой синхронизации
        $full_update = true;

        // Название параметра товара, используемого как бренд
        $start_time = microtime(true);
        $max_exec_time = min(30, @ini_get("max_execution_time"));
        if(empty($max_exec_time))
            $max_exec_time = 30;


        if($_GET['type'] == 'sale' && $_GET['mode'] == 'checkauth') {
            $this->registry['model']->logVisit(2000);
            print "success\n";
            print session_name()."\n";
            print session_id();
            $this->registry['model']->setExportSession(session_id());
        }

        if($_GET['type'] == 'sale' && $_GET['mode'] == 'init') {
            if ($_COOKIE['PHPSESSID'] == $this->registry['model']->getExportSession()) {
                $this->registry['model']->logVisit(2001);
                print "zip=no\n";
                print "file_limit=1000000\n";
            } else {
                $this->registry['model']->logVisit(404, false, $_SERVER['QUERY_STRING']);
                $this->registry['template']->show('404');
            }    
        }

        if($_GET['type'] == 'sale' && $_GET['mode'] == 'file') {
            $filename = $simpla->request->get('filename');

            $f = fopen($dir.$filename, 'ab');
            fwrite($f, file_get_contents('php://input'));
            fclose($f);
            $xml = simplexml_load_file($dir.$filename);	
            foreach($xml->Документ as $xml_order) {
                $order = new stdClass;
                $order->id = $xml_order->Номер;
                $existed_order = $simpla->orders->get_order(intval($order->id));

                $order->date = $xml_order->Дата.' '.$xml_order->Время;
                $order->name = $xml_order->Контрагенты->Контрагент->Наименование;
                if(isset($xml_order->ЗначенияРеквизитов->ЗначениеРеквизита))
                    foreach($xml_order->ЗначенияРеквизитов->ЗначениеРеквизита as $r) {
                        switch ($r->Наименование) {
                            case 'Проведен':
                                $proveden = ($r->Значение == 'true');
                                break;
                            case 'ПометкаУдаления':
                                $udalen = ($r->Значение == 'true');
                                break;
                        }
                    }

                if($udalen)
                    $order->status = 3;
                elseif($proveden)
                    $order->status = 1;
                elseif(!$proveden)
                    $order->status = 0;

                if($existed_order) {
                    $simpla->orders->update_order($order->id, $order);
                } else {
                    $order->id = $simpla->orders->add_order($order);
                }

                $purchases_ids = array();
                // Товары
                foreach($xml_order->Товары->Товар as $xml_product) {
                    $purchase = null;
                    //  Id товара и варианта (если есть) по 1С
                    $product_1c_id = $variant_1c_id = '';
                    @list($product_1c_id, $variant_1c_id) = explode('#', $xml_product->Ид);
                    if(empty($product_1c_id))
                        $product_1c_id = '';
                    if(empty($variant_1c_id))
                        $variant_1c_id = '';

                    // Ищем товар
                    $simpla->db->query('SELECT id FROM __products WHERE external_id=?', $product_1c_id);
                    $product_id = $simpla->db->result('id');
                    $simpla->db->query('SELECT id FROM __variants WHERE external_id=? AND product_id=?', $variant_1c_id, $product_id);
                    $variant_id = $simpla->db->result('id');

                    $purchase = new stdClass;		
                    $purchase->order_id = $order->id;
                    $purchase->product_id = $product_id;
                    $purchase->variant_id = $variant_id;

                    $purchase->sku = $xml_product->Артикул;			
                    $purchase->product_name = $xml_product->Наименование;
                    $purchase->amount = $xml_product->Количество;
                    $purchase->price = floatval($xml_product->ЦенаЗаЕдиницу);

                    if(isset($xml_product->Скидки->Скидка)) {
                        $discount = $xml_product->Скидки->Скидка->Процент;
                        $purchase->price = $purchase->price*(100-$discount)/100;
                    }

                    $simpla->db->query('SELECT id FROM __purchases WHERE order_id=? AND product_id=? AND variant_id=?', $order->id, $product_id, $variant_id);
                    $purchase_id = $simpla->db->result('id');
                    if(!empty($purchase_id))
                        $purchase_id = $simpla->orders->update_purchase($purchase_id, $purchase);
                    else
                        $purchase_id = $simpla->orders->add_purchase($purchase);
                    $purchases_ids[] = $purchase_id;
                }
                // Удалим покупки, которых нет в файле
                foreach($simpla->orders->get_purchases(array('order_id'=>intval($order->id))) as $purchase) {
                    if(!in_array($purchase->id, $purchases_ids))
                        $simpla->orders->delete_purchase($purchase->id);
                }

                $simpla->db->query('UPDATE __orders SET discount=0, total_price=? WHERE id=? LIMIT 1', $xml_order->Сумма, $order->id);

            }

            print "success";
            $simpla->settings->last_1c_orders_export_date = date("Y-m-d H:i:s");
        }

        if($_GET['type'] == 'sale' && $_GET['mode'] == 'query') {
            if ($_COOKIE['PHPSESSID'] == $this->registry['model']->getExportSession()) {
                $this->registry['model']->logVisit(2002);
                $no_spaces = '<?xml version="1.0" encoding="utf-8"?>
                            <КоммерческаяИнформация ВерсияСхемы="2.04" ДатаФормирования="' . date ( 'Y-m-d' )  . '"></КоммерческаяИнформация>';
                $xml = new SimpleXMLElement ( $no_spaces );
                $lastDate = $this->registry['model']->getLastExportDate();

                $orders = $this->registry['model']->getAllOrders();
                foreach($orders as $order) {
                    $date = new DateTime($order->date);
                    if ($date->format('Y-m-d H:i:s') > $lastDate) {

                        $doc = $xml->addChild ("Документ");
                        $doc->addChild ( "Ид", $order->id);
                        $doc->addChild ( "Номер", $order->id);
                        $doc->addChild ( "Дата", $date->format('Y-m-d'));
                        $doc->addChild ( "ХозОперация", "Заказ товара" );
                        $doc->addChild ( "Роль", "Продавец" );
                        $doc->addChild ( "Валюта", "руб");
                        $doc->addChild ( "Курс", "1" );
                        $doc->addChild ( "Сумма", $order->total);
                        $doc->addChild ( "Время",  $date->format('H:i:s'));
                        $doc->addChild ( "Комментарий", "Заказ на сайте ecomarketclever.ru");

                        // Контрагенты
                        $k1 = $doc->addChild ( 'Контрагенты' );
                        $k1_1 = $k1->addChild ( 'Контрагент' );
                        $k1_2 = $k1_1->addChild ( "Ид", $order->user);
                        $k1_2 = $k1_1->addChild ( "Наименование", $order->username);
                        $k1_2 = $k1_1->addChild ( "Роль", "Покупатель" );
                        $k1_2 = $k1_1->addChild ( "ПолноеНаименование", $order->username );

                        // Доп параметры
                        $addr = $k1_1->addChild ('АдресРегистрации');
                        $addr->addChild ( 'Представление', 'Самара' );
                        $addrField = $addr->addChild ( 'АдресноеПоле' );
                        $addrField->addChild ( 'Тип', 'Страна' );
                        $addrField->addChild ( 'Значение', 'RU' );
                        $addrField = $addr->addChild ( 'АдресноеПоле' );
                        $addrField->addChild ( 'Тип', 'Регион' );
                        $addrField->addChild ( 'Значение', 'Самарская область' );
                        $contacts = $k1_1->addChild ( 'Контакты' );
                        $cont = $contacts->addChild ( 'Контакт' );
                        $cont->addChild ( 'Тип', 'Телефон' );
                        $cont->addChild ( 'Значение', $order->phone );
                        $cont = $contacts->addChild ( 'Контакт' );
                        $cont->addChild ( 'Тип', 'Почта' );
                        $cont->addChild ( 'Значение', $order->email );

                        $t1 = $doc->addChild ( 'Товары' );
                        foreach($order->goods as $good) {
                            $id = $good->code;
                            $t1_1 = $t1->addChild ( 'Товар' );
                            if($id)
                                $t1_2 = $t1_1->addChild ( "Ид", $id);
                            $t1_2 = $t1_1->addChild ( "Артикул", $id);

                            $name = str_replace('&nbsp;', ' ', $good->name);
                            if($order->size)
                                $name .= " $order->size";
                            $t1_2 = $t1_1->addChild ( "Наименование", $name);
                            //$t1_2 = $t1_1->addChild ( "ЦенаЗаЕдиницу", $purchase->price*(100-$order->discount)/100);
                            $t1_2 = $t1_1->addChild ( "Количество", $good->quantity );
                            $t1_2 = $t1_1->addChild ( "Сумма", $good->price);

                            /*
                            $t1_2 = $t1_1->addChild ( "Скидки" );
                            $t1_3 = $t1_2->addChild ( "Скидка" );
                            $t1_4 = $t1_3->addChild ( "Сумма", $purchase->amount*$purchase->price*(100-$order->discount)/100);
                            $t1_4 = $t1_3->addChild ( "УчтеноВСумме", "true" );
                            */

                            $t1_2 = $t1_1->addChild ( "ЗначенияРеквизитов" );
                            $t1_3 = $t1_2->addChild ( "ЗначениеРеквизита" );
                            $t1_4 = $t1_3->addChild ( "Наименование", "ВидНоменклатуры" );
                            $t1_4 = $t1_3->addChild ( "Значение", "Товар" );

                            $t1_2 = $t1_1->addChild ( "ЗначенияРеквизитов" );
                            $t1_3 = $t1_2->addChild ( "ЗначениеРеквизита" );
                            $t1_4 = $t1_3->addChild ( "Наименование", "ТипНоменклатуры" );
                            $t1_4 = $t1_3->addChild ( "Значение", "Товар" );
                        }
                        // Доставка
                        /*
                        if($order->delivery_price>0 && !$order->separate_delivery) {
                            $t1 = $t1->addChild ( 'Товар' );
                            $t1->addChild ( "Ид", 'ORDER_DELIVERY');
                            $t1->addChild ( "Наименование", 'Доставка');
                            $t1->addChild ( "ЦенаЗаЕдиницу", $order->delivery_price);
                            $t1->addChild ( "Количество", 1 );
                            $t1->addChild ( "Сумма", $order->delivery_price);
                            $t1_2 = $t1->addChild ( "ЗначенияРеквизитов" );
                            $t1_3 = $t1_2->addChild ( "ЗначениеРеквизита" );
                            $t1_4 = $t1_3->addChild ( "Наименование", "ВидНоменклатуры" );
                            $t1_4 = $t1_3->addChild ( "Значение", "Услуга" );
                            $t1_2 = $t1->addChild ( "ЗначенияРеквизитов" );
                            $t1_3 = $t1_2->addChild ( "ЗначениеРеквизита" );
                            $t1_4 = $t1_3->addChild ( "Наименование", "ТипНоменклатуры" );
                            $t1_4 = $t1_3->addChild ( "Значение", "Услуга" );
                        }
                        */
                        // Способ оплаты и доставки
                        $s1_2 = $doc->addChild ( "ЗначенияРеквизитов");
                        /*
                        if($payment_method) {
                            $s1_3 = $s1_2->addChild ( "ЗначениеРеквизита");
                            $s1_3->addChild ( "Наименование", "Метод оплаты" );
                            $s1_3->addChild ( "Значение", $payment_method->name );
                        }
                        if($delivery) {
                            $s1_3 = $s1_2->addChild ( "ЗначениеРеквизита");
                            $s1_3->addChild ( "Наименование", "Способ доставки" );
                            $s1_3->addChild ( "Значение", $delivery->name);
                        }
                        $s1_3 = $s1_2->addChild ( "ЗначениеРеквизита");
                        $s1_3->addChild ( "Наименование", "Заказ оплачен" );
                        $s1_3->addChild ( "Значение", $order->paid?'true':'false' );
                        */
                        // Статус			
                        if($order->status == 1) {
                            $s1_3 = $s1_2->addChild ( "ЗначениеРеквизита" );
                            $s1_3->addChild ( "Наименование", "Статус заказа" );
                            $s1_3->addChild ( "Значение", "Новый" );
                        }
                        if($order->status == 3) {
                            $s1_3 = $s1_2->addChild ( "ЗначениеРеквизита" );
                            $s1_3->addChild ( "Наименование", "Статус заказа" );
                            $s1_3->addChild ( "Значение", "[N] Принят" );
                        }
                        if($order->status == 5) {
                            $s1_3 = $s1_2->addChild ( "ЗначениеРеквизита" );
                            $s1_3->addChild ( "Наименование", "Статус заказа" );
                            $s1_3->addChild ( "Значение", "[F] Доставлен" );
                        }
                        if($order->status == 8) {
                            $s1_3 = $s1_2->addChild ( "ЗначениеРеквизита" );
                            $s1_3->addChild ( "Наименование", "Отменен" );
                            $s1_3->addChild ( "Значение", "true" );
                        }
                    }    
                }
                header ( "Content-type: text/xml; charset=utf-8" );
                print "\xEF\xBB\xBF";
                print $xml->asXML ();
                $this->registry['model']->setLastExportDate(date("Y-m-d H:i:s"));
            } else {
                $this->registry['model']->logVisit(404, false, $_SERVER['QUERY_STRING']);
                $this->registry['template']->show('404');
            }    
        }

        if($_GET['type'] == 'sale' && $_GET['mode'] == 'success') {
            //$simpla->settings->last_1c_orders_export_date = date("Y-m-d H:i:s");
        }
    }
}
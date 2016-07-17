<?php
    include ('includes/startup.php');
    $model = new Model($registry);
    $registry->set('model', $model);
    $registry->set('userId', $model->getUserId());
    $registry->set('lastVisit', $model->getLastVisit());
    $registry->set('skintypes', $model->getCatalog('skintypes'));
    $registry->set('hairtypes', $model->getCatalog('hairtypes'));
    $registry->set('categories', $model->getCatalog('categories'));
    $registry->set('firms', $model->getCatalog('firms'));
    $registry->set('effects', $model->getCatalog('effects'));
    $registry->set('types', $model->getCatalog('types'));
    $registry->set('goods', $model->getAllGoods());
    
    //This is a temporary init for basket - SHOULD BE REMOVED
    $basketItem = new BasketItem();
    $basketItem->goodId=13;
    $basketItem->name="Мыло хозяйственное";
    $basketItem->size=100;
    $basketItem->price=50;
    $basketItem->quantity=2;
    $registry->set('basket', array($basketItem));
    

    $template = new Template($registry);
    $registry->set('template', $template);
            
    $router = new Router($registry);            
    $registry->set('router', $router);
        
    $router->setPath (site_path . 'controllers');            
    $router->delegate();
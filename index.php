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
    $registry->set('problems', $model->getCatalog('problems'));
    

    $template = new Template($registry);
    $registry->set('template', $template);
            
    $router = new Router($registry);            
    $registry->set('router', $router);
        
    $router->setPath (site_path . 'controllers');            
    $router->delegate();
<?php
    include ('includes/startup.php');
    $model = new Model($registry);
    $registry->set('model', $model);
    $registry->set('freeDelivery', 700);
    $registry->set('presentSum', 0);
    $registry->set('globalsale', false);
    define('currency', ' руб.');
    define('siteName', 'www.clubclever.ru');
    define('phoneNumber', '8 (846) 252 39 11');
    $model->getUser();
    //$_SESSION['user']->lastvisit = $model->getLastVisit();
    $registry->set('skintypes', $model->getCatalog('skintypes'));
    $registry->set('hairtypes', $model->getCatalog('hairtypes'));
    $registry->set('categories', $model->getCatalog('categories'));
    $registry->set('firms', $model->getFirms());
    $registry->set('effects', $model->getCatalog('effects'));
    $registry->set('types', $model->getTypes());
    $registry->set('supercats', $model->getSuperCats());
    $registry->set('problems', $model->getCatalog('problems'));
    $registry->set('branches', $model->getBranches());

    $isAdmin = ($_SESSION['user']->email == 'Nataliya.zhirnova@gmail.com' or $_SESSION['user']->email == 'Tev0205@gmail.com');
    $registry->set('isadmin', $isAdmin);

    $template = new Template($registry);
    $registry->set('template', $template);
            
    $router = new Router($registry);            
    $registry->set('router', $router);
        
    $router->setPath (site_path . 'controllers');
    $router->delegate();
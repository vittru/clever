<?php
    include ('includes/startup.php');
    $model = new Model($registry);
    $registry->set('model', $model);
    $registry->set('userId', $model->getUserId());
    $registry->set('lastVisit', $model->getLastVisit());

?>



        <?php
            $template = new Template($registry);
            $registry->set('template', $template);
            
            $router = new Router($registry);            
            $registry->set('router', $router);
            
            $router->setPath (site_path . 'controllers');            
            $router->delegate();

        ?>
        

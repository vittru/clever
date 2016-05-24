<?php
    include ('includes/startup.php');
    $model = new Model($registry);
    $registry->set('model', $model);
    $registry->set('userId', $model->getUserId());
    $registry->set('lastVisit', $model->getLastVisit());

?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="google-site-verification" content="iS4dE6K9BYoL5G8GA8ZT8wNSAhJd6IL-YyId6vl1sY0" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="content-language" content="ru" />
        <meta name="robots" content="all,follow" />

        <meta name="author" content="Vitaly Trusov" />

        <title>Клевер - удобный клуб для качественного развития</title>
        <meta name="description" content="Детский клуб 'Клевер' - удобный клуб для качественного развития" />
        <meta name="keywords" content="Детский клуб, клуб Клевер, развитие, занятия" />

        <link rel="index" href="./" title="Home" />
        <link rel="stylesheet" media="screen,projection,handheld" type="text/css" href="./css/ps.css" />
        <link rel="stylesheet" media="print" type="text/css" href="./css/print.css" />
    </head>

    <body>
        
        <div id='container'>
        <?php
            $template = new Template($registry);
            $registry->set('template', $template);
            
            $router = new Router($registry);            
            $registry->set('router', $router);
            
            $router->setPath (site_path . 'controllers');            
            $router->delegate();

        ?>
        
            <div id='footer'>
                <div float='left' class='noprint'>
                    <p>
                        <span class='noscreen'>
                            <a href='#header' title='Наверх ^'>Наверх ^</a>
                        </span>
                    </p>
                </div>
                <div><p id='copyright'>
                    &copy; 2016 <a href='mailto:vitaly.trusov@gmail.com'>Виталий Трусов</a>
                </p></div>
            </div>
        </div>
    </body>
</html>

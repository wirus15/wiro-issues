<!DOCTYPE html>

<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?= $this->pageTitle; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/css/style.css">
    </head>

    <body>
        <?php $notifications = $this->widget('application.widgets.NotificationsWidget'); ?>
        <div id="wrap">
            <div class="container-fluid">
                <nav id="main-menu">
                    <?php              
                    $this->widget('bootstrap.widgets.TbNavbar', array(
                        'brand' => Yii::app()->params['brand'] ?: Yii::app()->name,
                        'fixed' => 'top',
                        'fluid' => true,
                        'items' => array(
                            array(
                                'class' => 'bootstrap.widgets.TbMenu',
                                'items' => require_once __DIR__.'/mainmenu.php',
                            ),
                            array(
                                'class' => 'bootstrap.widgets.TbMenu',
                                'htmlOptions' => array('class' => 'pull-right'),
                                'encodeLabel' => false,
                                'items' => array(
                                    $notifications->link,
                                    array(
                                        'label' => 'Sign in',
                                        'url' => array('/user/login/login'),
                                        'visible' => Yii::app()->user->isGuest,
                                        'icon' => 'signin',
                                    ),
                                    array(
                                        'label' => 'Sign out ('.Yii::app()->user->name.')',
                                        'url' => array('/user/login/logout'),
                                        'visible' => !Yii::app()->user->isGuest,
                                        'icon' => 'off',
                                    ),
                                ),
                            ),
                        ),
                    ));
                    ?>
                </nav>

                <section id="page">
                    <nav id="breadcrumbs">
                        <?php
                        $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                            'links' => $this->breadcrumbs,
                        ));
                        ?>
                    </nav>
                    
                    <?php $this->widget('bootstrap.widgets.TbAlert'); ?>

                    <?= $content; ?>
                </section>
            </div>
            <div id="push"></div>
        </div>

        <footer id="footer">
            <div class="container">
                <div class="credit">Copyright &copy;
                    <?= date('Y'); ?>
                    by <?= Yii::app()->name; ?>. All Rights Reserved.
                </div>
            </div>
        </footer>
        <script type="text/javascript" src="<?= Yii::app()->baseUrl; ?>/js/script.js"></script>
    </body>
</html>

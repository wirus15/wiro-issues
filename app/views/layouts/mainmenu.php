<?php

return array(
    array(
        'label' => 'Issues',
        'url' => array('/issue/index'),
        'visible' => !Yii::app()->user->isGuest,
        'icon' => 'tasks',
    ),
    array(
        'label' => 'Create issue',
        'url' => array('/issue/create'),
        'visible' => !Yii::app()->user->isGuest,
        'icon' => 'plus',
    ),
    array(
        'label' => 'Categories',
        'url' => array('/category/index'),
        'visible' => Yii::app()->user->checkAccess('admin'),
        'icon' => 'folder-open',
    ),
    array(
        'label' => 'Users',
        'url' => array('/user/admin/index'),
        'visible' => Yii::app()->user->checkAccess('admin'),
        'icon' => 'group',
    ),
    
);

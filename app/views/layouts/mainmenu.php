<?php

return array(
    array(
        'label' => 'Users',
        'url' => array('/user/admin'),
        'visible' => !Yii::app()->user->isGuest,
        'icon' => 'group',
    ),
);

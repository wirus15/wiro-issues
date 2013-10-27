<?php

class NotificationsWidget extends CWidget
{
    /**
     *
     * @var CActiveDataProvider
     */
    private $notifications;
    
    public function init()
    {
        if(!Yii::app()->user->isGuest)
        {
            $this->notifications = new CActiveDataProvider('Notification', array(
                'criteria' => array(
                    'condition' => 't.userId=:user',
                    'with' => array('activity', 'activity.issue'),
                    'params' => array(
                        ':user' => Yii::app()->user->id,
                    ),
                ),
                'pagination' => false,
            ));
        }
    }
    
    public function run()
    {
        $this->render('index', array(
            'dataProvider' => $this->notifications,
        ));
    }
    
    public function getLink()
    {
        $count = $this->notifications->itemCount;
        return array(
            'label' => sprintf('Notifications (<span id="notification-count">%d</span>)', $count),
            'url' => '#',
            'visible' => !Yii::app()->user->isGuest,
            'icon' => 'bell-alt',
            'itemOptions' => array('class' => 'notifications'),
            'linkOptions' => array(
                'class' => $count ? 'show-notifications active' : 'show-notifications',
            ),
        );
    }
}

<?php

class NotificationController extends wiro\base\Controller
{
    protected $modelClass = 'Notification';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl',
            'postOnly + delete, deleteall',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionDelete($activityId)
    {
        Notification::model()->deleteByPk(array(
            'activityId' => $activityId,
            'userId' => Yii::app()->user->id,
        ));

        if (!Yii::app()->request->isAjaxRequest)
            $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionDeleteall()
    {
        Notification::model()->deleteAllByAttributes(array(
            'userId' => Yii::app()->user->id,
        ));

        if (!Yii::app()->request->isAjaxRequest)
            $this->redirect(Yii::app()->request->urlReferrer);
    }

}

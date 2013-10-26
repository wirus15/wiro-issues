<?php

class ActivityController extends wiro\base\Controller
{
    protected $modelClass = 'Activity';
    
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', 
            'postOnly + delete', 
        );
    }
    
    public function actions()
    {
        return array(
            'index' => 'wiro\actions\IndexAction',
            'update' => array(
                'class' => 'wiro\actions\UpdateAction',
                'beforePostAssignment' => function($model) {
                    if($model->userId != Yii::app()->user->id)
                        throw new CHttpException('Cannot update this activity.');
                },
                'redirectUrl' => function($model) {
                    return array('/issue/view', 'id'=>$model->issueId);
                },
            ),
            'delete' => array(
                'class' => 'wiro\actions\DeleteAction',
                'beforeDelete' => function($model) {
                    if($model->userId != Yii::app()->user->id)
                        throw new CHttpException('Cannot delete this activity.');
                },
                'redirectUrl' => function($model) {
                    return array('/issue/view', 'id'=>$model->issueId);
                },
            ),
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
}

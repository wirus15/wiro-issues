<?php

class IssueController extends wiro\base\Controller
{
    protected $modelClass = 'Issue';

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
    
    public function actions()
    {
        return array(
            'create' => array(
                'class' => 'wiro\actions\CreateAction',
                'beforePostAssignment' => function($model) { $model->authorId = Yii::app()->user->id; },
            ),
            'update' => array(
                'class' => 'wiro\actions\UpdateAction',
            ),
            'delete' => 'wiro\actions\DeleteAction',
            'index' => 'wiro\actions\IndexAction',
            'view' => 'wiro\actions\ViewAction',
        );
    }
    
    public function actionStatus($id, $status)
    {
        $model = $this->loadModel($id);
        $model->status = $status;
        $model->save();
        $this->redirect(array('view','id'=>$id));
    }
}

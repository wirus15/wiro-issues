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
                'beforePostAssignment' => function($model) {
                    if($model->authorId !== Yii::app()->user->id)
                        throw new CHttpException(403, 'You cannot edit this issue.');
                },
            ),
            'delete' => array(
                'class' => 'wiro\actions\DeleteAction',
                'beforeDelete' => function($model) {
                    if($model->authorId !== Yii::app()->user->id)
                        throw new CHttpException(403, 'You cannot delete this issue.');
                },
            ),
            'index' => 'wiro\actions\IndexAction',
            'view' => array(
                'class' => 'wiro\actions\ViewAction',
                'beforeRender' => function($model) {
                    $model->removeNotifications();
                },
            ),
        );
    }
    
    public function actionStatus($id, $status)
    {
        $model = $this->loadModel($id);
        $model->status = $status;
        $model->save();
        $this->redirect(array('view','id'=>$id));
    }
    
    public function actionComment($id)
    {
        $model = $this->loadModel($id);
        if(!empty($_POST['Activity']['activityData'])) {
            $model->addComment($_POST['Activity']['activityData']);
        }
        $this->redirect(array('view', 'id'=>$id));
    }
    
    public function actionWatch($id, $watch = true)
    {
        $model = $this->loadModel($id);
        if($watch)
            $model->addWatch();
        else
            $model->removeWatch();
        $this->redirect(array('view', 'id'=>$id));
    }
}

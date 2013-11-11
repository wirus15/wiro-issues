<?php

class AttachmentController extends wiro\base\Controller
{
    protected $modelClass = 'Attachment';
    
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', 
            'postOnly + create,delete', 
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
    
    public function actionCreate($id)
    {
        $model = new Attachment();
        $model->issueId = $id;
        $model->userId = Yii::app()->user->id;
        $model->file = Yii::app()->upload->getUploadedFile($model, 'file');
        
        if($model->validate()) {
            $model->fileName = $model->file->name;
            $model->filePath = Yii::app()->upload->saveUploadedFile($model->file);
            $model->save();
        }
        
        if($model->hasErrors('file'))
            Yii::app()->user->setFlash('error', $model->getError('file'));
        
        $this->redirect(array('/issue/view', 'id'=>$id));
    }
    
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        if(!$model->canEdit)
            throw new CHttpException(403, 'You cannot delete this attachment.');
        
        $model->delete();
        $this->redirect(array('/issue/view', 'id'=>$model->issueId));
    }
    
    public function actionDownload($id)
    {
        $model = $this->loadModel($id);
        $content = file_get_contents(Yii::app()->upload->uploadPath.'/'.$model->filePath);
        Yii::app()->request->sendFile($model->fileName, $content);
    }
}

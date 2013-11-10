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
        
    }
    
    public function actionDelete($id)
    {
        
    }
}

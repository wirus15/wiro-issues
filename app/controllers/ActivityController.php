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

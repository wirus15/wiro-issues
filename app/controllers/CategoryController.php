<?php

class CategoryController extends wiro\base\Controller
{
    protected $modelClass = 'Category';
    
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
            'create' => array(
                'class' => 'wiro\actions\CreateAction',
                'redirectUrl' => array('index'),
            ),
            'update' => array(
                'class' => 'wiro\actions\UpdateAction',
                'redirectUrl' => array('index'),
            ),
            'delete' => array(
                'class' => 'wiro\actions\DeleteAction',
                'beforeDelete' => function(Category $model) {
                    if($model->productsCount > 0) {
                        throw new CException('Cannot remove category that is not empty.');
                    }
                }
            ), 
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
                'roles' => array('admin'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }
}

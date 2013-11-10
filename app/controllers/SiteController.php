<?php

use wiro\base\Controller;

/**
 *
 * SiteController class
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @copyright 2013 2amigOS! Consultation Group LLC
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
class SiteController extends Controller
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl',
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
            array('deny', 
                'actions' => array('upload'),
                'users' => array('?'),
            ),
            array('allow', 
                'users' => array('*'),
            ),
        );
    }
    
    public function actions()
    {
        return array(
            'error' => 'wiro\actions\ErrorAction',
            'page' => 'wiro\modules\pages\actions\ViewAction',
            'upload' => 'wiro\actions\RedactorUploadAction',
        );
    }
}
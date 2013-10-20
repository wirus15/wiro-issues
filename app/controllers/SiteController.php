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

    public function actions()
    {
        return array(
            'error' => 'wiro\actions\ErrorAction',
            'page' => 'wiro\modules\pages\actions\ViewAction',
        );
    }

    public function actionIndex()
    {
        $this->render('index');
    }
}
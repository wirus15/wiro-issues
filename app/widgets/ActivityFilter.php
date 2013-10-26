<?php

class ActivityFilter extends CWidget
{
    /**
     *
     * @var Activity
     */
    public $model;
    /**
     *
     * @var CActiveDataProvider
     */
    public $dataProvider;
    /**
     *
     * @var array
     */
    public $buttons = array();
    /**
     *
     * @var array
     */
    public $htmlOptions = array();
    /**
     *
     * @var mixed
     */
    public $url;
    
    public function init()
    {
        if(!isset($this->url))
            $this->url = CMap::mergeArray(array($this->controller->route), $_GET);
    }
    
    public function run()
    {
        $buttons = array_map(array($this, 'button'), $this->buttons);
        foreach($buttons as $btn)
            echo TbHtml::linkButton($btn['label'], $btn);
    }
    
    public function button($params)
    {
        $type = $params['activityType'];
        unset($params['activityType']);
        
        if(!isset($params['url']))
            $params['url'] = $this->url;
        
        return CMap::mergeArray($params, array(
            'url' => array(
                CHtml::activeName($this->model, 'activityType') => $type,
                CHtml::activeName($this->model, 'issueId') => $this->model->issueId,
            ),
            'class' => $type==$this->model->activityType ? 'btn-mini active' : 'btn-mini',
        ));
    }
}
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
    
    private $currentType;
    
    public function init()
    {
        if(isset($_GET['Activity']['activityType'])) 
            $this->currentType = $_GET['Activity']['activityType'];
    }
    
    public function run()
    {
        $buttons = array_map(array($this, 'button'), $this->buttons);
        echo TbHtml::buttonGroup($buttons, $this->htmlOptions);
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
                $this->dataProvider->sort->sortVar => $this->currentType,
            ),
            'class' => $type==$this->currentType ? 'active' : '',
        ));
    }
}
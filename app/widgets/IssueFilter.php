<?php

class IssueFilter extends CWidget
{
    public $toggle = 'radio';
    public $dataClear;
    public $dataFilter;
    public $items = array();
    public $model;
    
    public function run()
    {
        $items = $this->prepareItems();
        
        echo TbHtml::buttonGroup($items, array(
            'toggle' => $this->toggle,
            'data-clear' => $this->formatAttributes($this->dataClear),
            'data-filter' => $this->formatAttributes($this->dataFilter),
        ));
    }
    
    private function prepareItems()
    {
        $hasActive = false;
        $th = $this;
        $items = array_map(function($item) use ($th, &$hasActive) {
            if($this->isActive($item)) {
                $hasActive = true;
                $item['class'] = 'active';
            }
            
            if(isset($item['filter'])) {
                $filter = $item['filter'];
                $item['htmlOptions']['data-filter'] = $this->formatAttributes($filter);
                unset($item['filter']);
            }
            if(isset($item['value'])) {
                $item['htmlOptions']['data-value'] = $item['value'];
                unset($item['value']);
            }
            return $item;
        }, $this->items);
        
        if(!$hasActive) 
            foreach($items as &$item)
                if(!empty($item['default']))
                    $item['class'] = 'active';    
        
        return $items;
    }
    
    private function isActive($item)
    {
        $filter = isset($item['filter']) ? $item['filter'] : $this->dataFilter;
        $value = isset($item['value']) ? $item['value'] : null;
        return $filter && $this->model->$filter == $value;
    }
    
    private function formatAttributes($attributes)
    {
        if(empty($attributes))
            return $attributes;
        
        $attributes = array_map('trim', explode(',', $attributes));
        $attributes = array_map(function($attribute) {
            return CHtml::activeId($this->model, $attribute);
        }, $attributes);
        
        return implode(',', $attributes);
    }
}
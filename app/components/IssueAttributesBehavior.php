<?php

class IssueAttributesBehavior extends CBehavior
{
    public function getStatusList()
    {
        return array(
            Issue::STATUS_NEW => 'New',
            Issue::STATUS_OPENED => 'Opened',
            Issue::STATUS_REOPENED => 'Re-Opened',
            Issue::STATUS_HALTED => 'Halted',
            Issue::STATUS_RESOLVED => 'Resolved',
            Issue::STATUS_CONFIRMED => 'Confirmed',
            Issue::STATUS_REJECTED => 'Rejected',
        );
    }
    
    public function getStatusName($status = null)
    {
        return $this->statusList[$status ?: $this->owner->status];
    }
    
    public function getStatusLabel($status = null)
    {
        $colors = array(
            Issue::STATUS_NEW => 'info',
            Issue::STATUS_OPENED => 'warning',
            Issue::STATUS_REOPENED => 'warning',
            Issue::STATUS_HALTED => '',
            Issue::STATUS_RESOLVED => 'success',
            Issue::STATUS_CONFIRMED => 'success',
            Issue::STATUS_REJECTED => 'inverse',
        );
        
        $status = $status ?: $this->owner->status;
        return TbHtml::labelTb($this->getStatusName($status), array('color' => $colors[$status]));
    }
    
    public function getTypeList()
    {
        return array(
            Issue::TYPE_FEATURE => 'Feature',
            Issue::TYPE_BUG => 'Bug',
            Issue::TYPE_ENHANCEMENT => 'Enhancement',
        );
    }
    
    public function getTypeName($type = null)
    {
        return $this->typeList[$type ?: $this->owner->type];
    }
    
    public function getTypeLabel($type = null)
    {
        $icons = array(
            Issue::TYPE_FEATURE => 'puzzle-piece',
            Issue::TYPE_BUG => 'bug',
            Issue::TYPE_ENHANCEMENT => 'lightbulb'
        );
        
        $type = $type ?: $this->owner->type;
        $label = TbHtml::icon($icons[$type]);
        $label .= '&nbsp;';
        $label .= TbHtml::encode($this->getTypeName($type));
        return $label;
    }
    
    public function getPriorityList()
    {
        return array(
            Issue::PRIORITY_LOW => 'Low',
            Issue::PRIORITY_MEDIUM => 'Medium',
            Issue::PRIORITY_HIGH => 'High',
            Issue::PRIORITY_IMMEDIATE => 'Immediate',
        );
    }
    
    public function getPriorityName($priority = null)
    {
        return $this->priorityList[$priority ?: $this->owner->priority];
    }
    
    public function getPriorityLabel($priority = null)
    {
        $colors = array(
            Issue::PRIORITY_LOW => 'success',
            Issue::PRIORITY_MEDIUM => 'warning',
            Issue::PRIORITY_HIGH => 'important',
            Issue::PRIORITY_IMMEDIATE => 'very-important',
        );
        
        $priority = $priority ?: $this->owner->priority;
        return TbHtml::labelTb($this->getPriorityName($priority), array('color' => $colors[$priority]));
    }
    
}
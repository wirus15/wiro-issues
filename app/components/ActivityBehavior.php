<?php

use wiro\modules\users\models\User;

class ActivityBehavior extends CActiveRecordBehavior
{
    private $originalProperties = array();
    
    public function afterFind($event)
    {
        $this->originalProperties = $this->owner->attributes;
    }
    
    public function afterSave($event)
    {
        if(!$this->owner->isNewRecord) {
            $activities = array(
                'categoryId' => Activity::TYPE_UPDATE,
                'type' => Activity::TYPE_UPDATE,
                'title' => Activity::TYPE_UPDATE,
                'description' => Activity::TYPE_UPDATE,
                'assignedTo' => Activity::TYPE_ASSIGNMENT,
                'status' => Activity::TYPE_STATUS_CHANGE,
                'priority' => Activity::TYPE_PRIORITY_CHANGE,
            );

            foreach($activities as $property => $activity)
            {
                if($this->originalProperties[$property] != $this->owner->$property)
                    $this->createActivity($activity);
            }
        }
    }
    
    private function createActivity($type)
    {
        $activity = new Activity();
        $activity->userId = Yii::app()->user->id;
        $activity->issueId = $this->owner->issueId;
        $activity->activityType = $type;
        
        switch($type) {
            case Activity::TYPE_STATUS_CHANGE:
                $activity->activityData = $this->owner->status;
                break;
            case Activity::TYPE_PRIORITY_CHANGE:
                $activity->activityData = $this->owner->priority;
                break;
            case Activity::TYPE_ASSIGNMENT:
                $username = $this->owner->assignedTo
                    ? User::model()->findByPk($this->owner->assignedTo)->username
                    : '<span class="nobody">nobody</span>';
                $activity->activityData = $username;
                break;
        }
        
        $activity->save();
    }
}
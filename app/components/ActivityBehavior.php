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
    
    public function addComment($text)
    {
        $this->createActivity(Activity::TYPE_COMMENT, $text);
    }
    
    private function createActivity($type, $content=null)
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
            case Activity::TYPE_COMMENT:
                $activity->activityData = $content;
                break;
        }
        
        $activity->save();
    }
    
    public function getIsBeingWatched($userId = null)
    {
        return Watch::model()->count('userId=:user and issueId=:issue', array(
            ':user' => $userId ?: Yii::app()->user->id,
            ':issue' => $this->owner->issueId,
        )) > 0;
    }
    
    public function addWatch($userId = null)
    {
        if(!$this->getIsBeingWatched($userId)) {
            $watch = new Watch();
            $watch->userId = $userId ?: Yii::app()->user->id;
            $watch->issueId = $this->owner->issueId;
            return $watch->save();
        } 
        return false;
    }
    
    public function removeWatch($userId = null)
    {
        Watch::model()->deleteAllByAttributes(array(
            'userId' => $userId ?: Yii::app()->user->id,
            'issueId' => $this->owner->issueId,
        ));
    }
}
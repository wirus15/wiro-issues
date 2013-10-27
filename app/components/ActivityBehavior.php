<?php

use wiro\modules\users\models\User;

/**
 * @property Issue $owner
 */
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
        
        else {
            $this->addWatch();
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
                if($this->owner->assignedTo) {
                    $username = User::model()->findByPk($this->owner->assignedTo)->username;
                    $activity->activityData = $username;
                    $this->addWatch($this->owner->assignedTo);
                } else {
                    $activity->activityData = '<span class="nobody">nobody</span>';
                }
                break;
            case Activity::TYPE_COMMENT:
                $activity->activityData = $content;
                break;
        }
        
        if($activity->save()) {
            $this->sendNotifications($activity->activityId);
        }
    }
    
    public function getIsBeingWatched($userId = null)
    {
        return Watch::model()->exists('userId=:user and issueId=:issue', array(
            ':user' => $userId ?: Yii::app()->user->id,
            ':issue' => $this->owner->issueId,
        ));
    }
    
    public function addWatch($userId = null)
    {
        if(!$this->getIsBeingWatched($userId)) {
            $watch = new Watch();
            $watch->userId = $userId ?: Yii::app()->user->id;
            $watch->issueId = $this->owner->issueId;
            $watch->save();
        } 
        return false;
    }
    
    public function removeWatch($userId = null)
    {
        Watch::model()->deleteByPk(array(
            'userId' => $userId ?: Yii::app()->user->id,
            'issueId' => $this->owner->issueId,
        ));
    }
    
    public function sendNotifications($activityId)
    {
        foreach($this->owner->watches as $watch)
        {
            if($watch->userId !== Yii::app()->user->id)
            {
                $notification = new Notification();
                $notification->userId = $watch->userId;
                $notification->activityId = $activityId;
                $notification->save();
            }
        }
    }
    
    public function removeNotifications($userId = null)
    {
        $builder = Yii::app()->db->commandBuilder;
        
        $subquery = $builder->createFindCommand(
            Activity::model()->tableName(), 
            new CDbCriteria(array(
                'select' => 'activityId',
                'condition' => 'issueId=:issue',
            ))
        )->text;
        
        return Notification::model()->deleteAll(array(
            'condition' => 'userId=:user and activityId in ('.$subquery.')',
            'params' => array(
                ':user' => $userId ?: Yii::app()->user->id,
                ':issue' => $this->owner->issueId,
            ),
        ));
    }
}
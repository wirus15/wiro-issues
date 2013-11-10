<?php

use wiro\modules\users\models\User;

Yii::import('application.components.NotificationManager');

/**
 * @property Issue $owner
 */
class ActivityBehavior extends CActiveRecordBehavior
{
    private $originalProperties = array();
    private $notifications;
    
    public function attach($owner)
    {
        parent::attach($owner);
        $this->notifications = new NotificationManager($owner);
    }
    
    public function afterFind($event)
    {
        $this->originalProperties = $this->owner->attributes;
    }
    
    public function afterSave($event)
    {
        if(!$this->owner->isNewRecord) {
            $this->watchForChanges();
        }
        
        else {
            $this->addWatch();
            if($this->owner->assignedTo && $this->owner->assignedTo !== Yii::app()->user->id)
                $this->createActivity(Activity::TYPE_ASSIGNMENT);
            
            else if(!$this->owner->assignedTo)
                $this->notifications->sendNewIssueEmail();
        }
    }
    
    private function watchForChanges()
    {
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
    
    public function beforeDelete($event)
    {
        $this->createActivity(Activity::TYPE_DELETE);
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
                    $user = User::model()->findByPk($this->owner->assignedTo);
                    $activity->activityData = $user->username;
                    $this->addWatch($this->owner->assignedTo);
                    $this->notifications->sendAssignmentEmail($user->email);
                } else {
                    $activity->activityData = '<span class="nobody">nobody</span>';
                }
                break;
            case Activity::TYPE_COMMENT:
                $activity->activityData = $content;
                break;
            case Activity::TYPE_DELETE:
                $activity->issueId = null;
                $activity->activityData = '#'.$this->owner->issueId.': '.$this->owner->title;
        }
        
        if($activity->save()) {
            $this->notifications->sendNotifications($activity->activityId);
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
    
    public function removeNotifications($userId = null)
    {
        return $this->notifications->removeNotifications($userId);
    }
}
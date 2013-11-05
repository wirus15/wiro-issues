<?php

use wiro\components\mail\YiiMailMessage;
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
            if($this->owner->assignedTo && $this->owner->assignedTo !== Yii::app()->user->id)
                $this->createActivity(Activity::TYPE_ASSIGNMENT);
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
                    $user = User::model()->findByPk($this->owner->assignedTo);
                    $activity->activityData = $user->username;
                    $this->addWatch($this->owner->assignedTo);
                    $this->notifyByEmail($user->email);
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
        $watches = $this->owner->isNewRecord
                ? Watch::model()->findAllByAttributes(array('issueId' => $this->owner->issueId))
                : $this->owner->watches;
        
        foreach($watches as $watch)
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
    
    private function notifyByEmail($email)
    {
        $body = Yii::app()->controller->renderPartial('/email/assignment', array(
            'user' => Yii::app()->user->name,
            'issue' => $this->owner,
            'link' => Yii::app()->controller->createAbsoluteUrl('/issue/view', array('id'=>$this->owner->issueId)),
        ), true);
	   
	$message = new YiiMailMessage;
	$message->setBody($body, 'text/html');
	$message->setSubject(Yii::app()->controller->emailSubject);
	$message->setFrom(Yii::app()->params->adminEmail);
	$message->setTo($email);
        
        var_dump($message); die();
	Yii::app()->mail->send($message);
    }
}
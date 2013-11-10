<?php

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class NotificationManager extends CComponent
{
    private $issue;
    
    public function __construct($issue)
    {
        $this->issue = $issue;
    }
    
    public function sendNotifications($activityId)
    {
        $watches = Watch::model()->findAllByAttributes(array('issueId' => $this->issue->issueId));
        
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
                ':issue' => $this->issue->issueId,
            ),
        ));
    }
      
    public function sendNewIssueEmail()
    {
        if(!$address = Yii::app()->params['newIssueNotificationEmail'])
            return false;
        
        return $this->sendEmail($address, '/email/newissue');
    }
    
    public function sendAssignmentEmail($address)
    {
        return $this->sendEmail($address, '/email/assignment');
    }
    
    private function sendEmail($address, $view)
    {
        $body = Yii::app()->controller->renderPartial($view, array(
            'user' => Yii::app()->user->name,
            'issue' => $this->issue,
            'link' => Yii::app()->controller->createAbsoluteUrl('/issue/view', array('id'=>$this->issue->issueId)),
        ), true);
	   
	$message = new YiiMailMessage;
	$message->setBody($body, 'text/html');
	$message->setSubject(Yii::app()->controller->emailSubject);
	$message->setFrom(Yii::app()->params->adminEmail);
	$message->setTo($address);
        
	return Yii::app()->mail->send($message);
    }
}

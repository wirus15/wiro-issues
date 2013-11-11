<?php

/**
 * This is the model class for table "{{attachments}}".
 *
 * The followings are the available columns in table '{{attachments}}':
 * @property integer $attachmentId
 * @property integer $issueId
 * @property integer $userId
 * @property string $fileName
 * @property string $filePath
 * @property string $dateCreated
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Issue $issue
 * @property string $url
 */
class Attachment extends wiro\base\ActiveRecord
{
    /**
     *
     * @var CUploadedFile
     */
    public $file;
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{attachments}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('file', 'file', 'maxSize'=>10485760),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'issue' => array(self::BELONGS_TO, 'Issue', 'issueId'),
            'user' => array(self::BELONGS_TO, 'wiro\modules\users\models\User', 'userId'),
        );
    }
    
    public function behaviors()
    {
        return array(
            'timestamp' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
		'createAttribute' => 'dateCreated',
		'timestampExpression' => 'wiro\helpers\DateHelper::now()',
            ),
        );
    }
    
    public function getUrl()
    {
        return Yii::app()->upload->uploadUrl.'/'.$this->filePath;
    }
    
    public function getCanEdit($userId = null)
    {
        $userId = $userId ?: Yii::app()->user->id;
        return Yii::app()->user->checkAccess('admin') ||
                $this->userId === $userId;
    }
    
    protected function afterDelete()
    {
        parent::afterDelete();
        unlink(Yii::app()->upload->uploadPath.'/'.$this->filePath);
    }
}

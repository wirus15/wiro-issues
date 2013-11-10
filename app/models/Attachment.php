<?php

/**
 * This is the model class for table "{{attachments}}".
 *
 * The followings are the available columns in table '{{attachments}}':
 * @property integer $attachmentId
 * @property integer $issueId
 * @property integer $userId
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
            array('file', 'file', 'maxSize'=>10485760, 'tooLarge'=>'Uploaded files cannot be larger than 10 MB.'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'issue' => array(self::BELONGS_TO, 'Issue', 'issueId'),
            'user' => array(self::BELONGS_TO, 'Users', 'userId'),
        );
    }
    
    public function getUrl()
    {
        return Yii::app()->upload->uploadUrl.'/'.$this->filePath;
    }
}

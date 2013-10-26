<?php

/**
 * This is the model class for table "{{watches}}".
 *
 * The followings are the available columns in table '{{watches}}':
 * @property integer $userId
 * @property integer $issueId
 */
class Watch extends wiro\base\ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{watches}}';
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'wiro\modules\users\models\User', 'userId'),
            'issue' => array(self::BELONGS_TO, 'Issue', 'issueId'),
        );
    }
    
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Watch the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}

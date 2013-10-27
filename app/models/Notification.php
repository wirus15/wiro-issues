<?php

/**
 * This is the model class for table "{{notifications}}".
 *
 * The followings are the available columns in table '{{notifications}}':
 * @property integer $userId
 * @property integer $activityId
 */
class Notification extends wiro\base\ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{notifications}}';
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'wiro\modules\users\models\User', 'userId'),
            'activity' => array(self::BELONGS_TO, 'Activity', 'activityId'),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Notification the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

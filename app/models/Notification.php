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
}

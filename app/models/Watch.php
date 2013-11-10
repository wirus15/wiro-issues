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
}

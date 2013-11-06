<?php

/**
 * This is the model class for table "{{activities}}".
 *
 * The followings are the available columns in table '{{activities}}':
 * @property integer $activityId
 * @property integer $userId
 * @property integer $issueId
 * @property integer $activityType
 * @property string $activityData
 * @property string $dateCreated
 */
class Activity extends wiro\base\ActiveRecord
{
    const TYPE_UPDATE = 1;
    const TYPE_STATUS_CHANGE = 2;
    const TYPE_PRIORITY_CHANGE = 3;
    const TYPE_COMMENT = 4;
    const TYPE_ASSIGNMENT = 5;
    const TYPE_DELETE = 6;
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{activities}}';
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
    
    public function rules()
    {
        return array(
            array('activityData', 'safe', 'on' => 'update'),
            array('issueId, activityType', 'safe', 'on' => 'search'),
        );
    }
    
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'activityId' => 'Activity',
            'userId' => 'User',
            'issueId' => 'Issue',
        );
    }
    
    public function behaviors()
    {
        return array(
            'timestamp' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
		'createAttribute' => 'dateCreated',
                'updateAttribute' => null,
		'timestampExpression' => 'Yii::app()->dateFormatter->format(\'yyyy-MM-dd HH:mm:ss\', time())',
            ),
        );
    }
    
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        if(isset($_GET['Activity']))
            $this->attributes = $_GET['Activity'];   
        
        $criteria = new CDbCriteria;
        $criteria->with = array('issue', 'user');
        $criteria->compare('t.issueId', $this->issueId);
        $criteria->compare('t.activityType', $this->activityType);
 
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Activity the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}

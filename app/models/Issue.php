<?php

/**
 * This is the model class for table "{{issues}}".
 *
 * The followings are the available columns in table '{{issues}}':
 * @property integer $issueId
 * @property integer $authorId
 * @property integer $categoryId
 * @property integer $type
 * @property string $title
 * @property string $description
 * @property integer $assignedTo
 * @property integer $status
 * @property integer $priority
 * @property string $dateCreated
 * @property string $dateModified
 */
class Issue extends wiro\base\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_CONFIRMED = 2;
    const STATUS_OPENED = 3;
    const STATUS_HALTED = 5;
    const STATUS_RESOLVED = 6;
    const STATUS_RESOLVED_CONFIRMED = 7;
    const STATUS_REJECTED = 8;
    
    const STATUS_SCOPE_ACTIVE = 1;
    const STATUS_SCOPE_INACTIVE = 2;
    
    const TYPE_FEATURE = 1;
    const TYPE_BUG = 2;
    const TYPE_ENHANCEMENT = 3;
    
    const PRIORITY_LOW = 1;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_HIGH = 3;
    const PRIORITY_IMMEDIATE = 4;
    
    public $statusScope = self::STATUS_SCOPE_ACTIVE;
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{issues}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('categoryId, type, title, status, priority', 'required'),
            array('title', 'length', 'max' => 60),
            array('categoryId, assignedTo, type, description, status', 'safe'),
            array('issueId, authorId, categoryId, type, title, description, assignedTo, status, statusScope, dateCreated, dateModified', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'category' => array(self::BELONGS_TO, 'Category', 'categoryId'),
            'author' => array(self::BELONGS_TO, 'wiro\modules\users\models\User', 'authorId'),
            'assignee' => array(self::BELONGS_TO, 'wiro\modules\users\models\User', 'assignedTo'),
            'activities' => array(self::HAS_MANY, 'Activity', 'issueId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'issueId' => '#ID',
            'authorId' => 'Author',
            'categoryId' => 'Category',
            'type' => 'Type',
            'title' => 'Title',
            'priority' => 'Priority',
            'description' => 'Description',
            'assignedTo' => 'Assigned To',
            'status' => 'Status',
            'dateCreated' => 'Created',
            'dateModified' => 'Last modified',
        );
    }
    
    public function behaviors()
    {
        return array(
            'timestamp' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
		'createAttribute' => 'dateCreated',
		'updateAttribute' => 'dateModified',
                'timestampExpression' => 'Yii::app()->dateFormatter->format(\'yyyy-MM-dd HH:mm:ss\', time())',
            ),
            'activity' => array(
                'class' => 'application.components.ActivityBehavior',
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
        $criteria = new CDbCriteria;
        
        $criteria->compare('issueId', $this->issueId);
        $criteria->compare('authorId', $this->authorId);
        $criteria->compare('categoryId', $this->categoryId);
        $criteria->compare('priority', $this->priority);
        $criteria->compare('type', $this->type);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('status', $this->status);
        
        if($this->assignedTo === 'unassigned') 
            $criteria->addCondition('t.assignedTo is null');
        else
            $criteria->compare('assignedTo', $this->assignedTo);
        
        if($this->statusScope == self::STATUS_SCOPE_ACTIVE)
            $criteria->compare('status', '<'.self::STATUS_RESOLVED_CONFIRMED);
        if($this->statusScope == self::STATUS_SCOPE_INACTIVE)
            $criteria->compare('status', '>'.self::STATUS_RESOLVED);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'priority desc, dateCreated asc',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Issue the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_NEW => 'New',
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_OPENED => 'Opened',
            self::STATUS_HALTED => 'Halted',
            self::STATUS_RESOLVED => 'Resolved',
            self::STATUS_RESOLVED_CONFIRMED => 'Resolved & Confirmed',
            self::STATUS_REJECTED => 'Rejected',
        );
    }
    
    public function getStatusName($status = null)
    {
        return $this->statusList[$status ?: $this->status];
    }
    
    public function getTypeList()
    {
        return array(
            self::TYPE_FEATURE => 'Feature',
            self::TYPE_BUG => 'Bug',
            self::TYPE_ENHANCEMENT => 'Enhancement',
        );
    }
    
    public function getTypeName($type = null)
    {
        return $this->typeList[$type ?: $this->type];
    }
    
    public function getPriorityList()
    {
        return array(
            self::PRIORITY_LOW => 'Low',
            self::PRIORITY_MEDIUM => 'Medium',
            self::PRIORITY_HIGH => 'High',
            self::PRIORITY_IMMEDIATE => 'Immediate',
        );
    }
    
    public function getPriorityName($priority = null)
    {
        return $this->priorityList[$priority ?: $this->priority];
    }
    
    public function getTypeLabel($type = null)
    {
        $icons = array(
            Issue::TYPE_FEATURE => 'puzzle-piece',
            Issue::TYPE_BUG => 'bug',
            Issue::TYPE_ENHANCEMENT => 'lightbulb'
        );
        
        $type = $type ?: $this->type;
        $label = TbHtml::icon($icons[$type]);
        $label .= '&nbsp;';
        $label .= TbHtml::encode($this->getTypeName($type));
        return $label;
    }
    
    public function getPriorityLabel($priority = null)
    {
        $colors = array(
            Issue::PRIORITY_LOW => 'success',
            Issue::PRIORITY_MEDIUM => 'warning',
            Issue::PRIORITY_HIGH => 'important',
            Issue::PRIORITY_IMMEDIATE => 'very-important',
        );
        
        $priority = $priority ?: $this->priority;
        return TbHtml::labelTb($this->getPriorityName($priority), array('color' => $colors[$priority]));
    }
    
    public function getStatusLabel($status = null)
    {
        $colors = array(
            Issue::STATUS_NEW => 'info',
            Issue::STATUS_CONFIRMED => 'info',
            Issue::STATUS_OPENED => 'warning',
            Issue::STATUS_HALTED => '',
            Issue::STATUS_RESOLVED => 'success',
            Issue::STATUS_RESOLVED_CONFIRMED => 'success',
            Issue::STATUS_REJECTED => 'inverse',
        );
        
        $status = $status ?: $this->status;
        return TbHtml::labelTb($this->getStatusName($status), array('color' => $colors[$status]));
    }
}

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
 * @property Category $category
 * @property User $assignee
 * @property Activity[] $activities
 * @property Watch[] $watches 
 * @property Attachment[] $attachments
 */
class Issue extends wiro\base\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_OPENED = 2;
    const STATUS_REOPENED = 3;
    const STATUS_HALTED = 4;
    const STATUS_RESOLVED = 5;
    const STATUS_CONFIRMED = 6;
    const STATUS_REJECTED = 7;
    
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
    public $watchedScope = false;
    
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
            array('issueId, authorId, categoryId, type, title, description, assignedTo, status, statusScope, watchedScope, dateCreated, dateModified', 'safe', 'on' => 'search'),
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
            'watches' => array(self::HAS_MANY, 'Watch', 'issueId'),
            'attachments' => array(self::HAS_MANY, 'Attachment', 'issueId'),
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
            'issue-attributes' => array(
                'class' => 'application.components.IssueAttributesBehavior',
            ),
            'remember-filters' => array(
                'class' => 'ext.ERememberFiltersBehavior',
            ),
        );
    }
    
    public function scopes() 
    {
        return array(
            'active' => array(
                'condition' => 'status<:confirmed',
                'params' => array(':confirmed' => self::STATUS_CONFIRMED),
            ),
            'inactive' => array(
                'condition' => 'status>=:confirmed',
                'params' => array(':confirmed' => self::STATUS_CONFIRMED),
            ),
            'watched' => array(
                'with' => array('watches'),
                'condition' => 'watches.userId=:user',
                'params' => array(':user' => Yii::app()->user->id),
                'together' => true,
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
        $criteria->compare('dateCreated', $this->dateCreated);
        
        if($this->assignedTo === 'unassigned') 
            $criteria->addCondition('t.assignedTo is null');
        else
            $criteria->compare('assignedTo', $this->assignedTo);
        
        if($this->statusScope == self::STATUS_SCOPE_ACTIVE)
            $criteria->scopes[] = 'active';
        if($this->statusScope == self::STATUS_SCOPE_INACTIVE)
            $criteria->scopes[] = 'inactive';
        if($this->watchedScope)
            $criteria->scopes[] = 'watched';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'priority desc, dateCreated asc',
            ),
            'pagination' => array(
                'pageSize' => 30,
            ),
        ));
    }
    
    public function getCanEdit($userId = null)
    {
        $userId = $userId ?: Yii::app()->user->id;
        return Yii::app()->user->checkAccess('admin') || $this->authorId===$userId;
    }
}

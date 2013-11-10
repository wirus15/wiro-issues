<?php

/**
 * This is the model class for table "{{categories}}".
 *
 * The followings are the available columns in table '{{categories}}':
 * @property integer $categoryId
 * @property string $categoryName
 */
class Category extends wiro\base\ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{categories}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('categoryName', 'required'),
            array('categoryName', 'length', 'max' => 40),
            array('categoryName', 'unique'),
            array('categoryId, categoryName', 'safe', 'on' => 'search'),
        );
    }
    
    public function relations()
    {
        return array(
            'issues' => array(self::HAS_MANY, 'Issue', 'categoryId'),
            'issueCount' => array(self::STAT, 'Issue', 'categoryId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'categoryId' => 'Category ID',
            'categoryName' => 'Category Name',
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
        return new CActiveDataProvider($this);
    }
}

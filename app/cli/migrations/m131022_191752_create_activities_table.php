<?php

class m131022_191752_create_activities_table extends CDbMigration 
{
    public function safeUp()
    {
        $this -> createTable('{{activities}}', array(
            'activityId' => 'pk',
            'userId' => 'integer',
            'issueId' => 'integer',
            'activityType' => 'integer',
            'activityData' => 'text',
            'dateCreated' => 'datetime',
        ));
    }

    public function safeDown() 
    {
        $this -> dropTable('{{activities}}');
    }

}

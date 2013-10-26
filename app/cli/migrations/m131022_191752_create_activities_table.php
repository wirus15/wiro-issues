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
            'foreign key (userId) references {{users}}(userId) on update cascade on delete restrict',
            'foreign key (issueId) references {{issues}}(issueId) on update cascade on delete cascade',
        ));
    }

    public function safeDown() 
    {
        $this -> dropTable('{{activities}}');
    }

}

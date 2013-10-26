<?php

class m131020_184216_create_issues_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{issues}}', array(
            'issueId' => 'pk',
            'authorId' => 'integer not null',
            'categoryId' => 'integer not null',
            'type' => 'integer not null',
            'priority' => 'integer not null',
            'title' => 'string not null',
            'description' => 'text',
            'assignedTo' => 'integer',
            'status' => 'integer not null',
            'dateCreated' => 'datetime',
            'dateModified' => 'datetime',
            'foreign key (authorId) references {{users}}(userId) on update cascade on delete restrict',
            'foreign key (categoryId) references {{categories}}(categoryId) on update cascade on delete restrict',
            'foreign key (assignedTo) references {{users}}(userId) on update cascade on delete set null',
        ));
    }

    public function safeDown()
    {
        $this->dropTable('{{issues}}');
    }

}

<?php

class m131026_143614_create_watches_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{watches}}', array(
            'userId' => 'integer not null',
            'issueId' => 'integer not null',
            'primary key (userId, issueId)',
            'foreign key (userId) references {{users}}(userId) on update cascade on delete cascade',
            'foreign key (issueId) references {{issues}}(issueId) on update cascade on delete cascade',
        ));
    }
    
    public function safeDown()
    {
        $this->dropTable('{{watches}}');
    }
}

<?php

class m131110_133743_create_attachments_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{attachments}}', array(
            'attachmentId' => 'pk',
            'issueId' => 'integer not null',
            'userId' => 'integer',
            'filePath' => 'string not null',
            'dateCreated' => 'datetime not null',
            'foreign key (issueId) references {{issues}}(issueId) on update cascade on delete cascade',
            'foreign key (userId) references {{users}}(userId) on update cascade on delete set null',
        ));
    }

    public function safeDown()
    {
        $this->dropTable('{{attachments}}');
    }

}

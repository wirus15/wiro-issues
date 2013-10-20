<?php

class m130713_205646_create_users_table extends CDbMigration
{

    public function safeUp()
    {
        $this->createTable('{{users}}', array(
            'userId' => 'pk',
            'username' => 'string not null unique',
            'password' => 'string not null',
            'email' => 'string not null unique',
            'active' => 'boolean',
            'activationCode' => 'string',
            'registrationDate' => 'datetime',
            'lastLogin' => 'datetime',
            'suspended' => 'boolean default 0',
            'suspensionReason' => 'text',
            'role' => 'string default user',
        ));

        $this->createTable('{{user_profiles}}', array(
            'profileId' => 'pk',
            'userId' => 'integer not null',
            'companyName' => 'string',
            'firstName' => 'string',
            'lastName' => 'string',
            'phone' => 'string',
            'address' => 'text',
        ));

        $this->createTable('{{authitem}}', array(
            'name' => 'varchar(64) not null',
            'type' => 'integer not null',
            'description' => 'text',
            'bizrule' => 'text',
            'data' => 'text',
            'primary key (name)',
        ));

        $this->createTable('{{authitemchild}}', array(
            'parent' => 'varchar(64) not null',
            'child' => 'varchar(64) not null',
            'primary key (parent,child)',
            'foreign key (parent) references `{{authitem}}(name)` on delete cascade on update cascade',
            'foreign key (child) references `{{authitem}}(name)` on delete cascade on update cascade',
        ));

        $this->createTable('{{authassignment}}', array(
            'itemname' => 'varchar(64) not null',
            'userid' => 'varchar(64) not null',
            'bizrule' => 'text',
            'data' => 'text',
            'primary key (itemname,userid)',
            'foreign key (itemname) references `{{authitem}}(name)` on delete cascade on update cascade',
        ));
    }

    public function safeDown()
    {
        $this->dropTable('{{users}}');
        $this->dropTable('{{authitem}}');
        $this->dropTable('{{authitemchild}}');
        $this->dropTable('{{authassignment}}');
    }
}
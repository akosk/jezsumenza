<?php

use yii\db\Schema;
use yii\db\Migration;

class m161214_132735_contact extends Migration
{
    public function up()
    {
        $q = 'CREATE TABLE contact
(
    id INT(11) PRIMARY KEY NOT NULL,
    user_id INT(11),
    subject TEXT COMMENT \'Üzenet címe\',
    body TEXT COMMENT \'Üzenet\',
    ip VARCHAR(255),
    CONSTRAINT contact_user_id_fk FOREIGN KEY (user_id) REFERENCES user (id)
);';
        $this->execute($q);
        $q = "CREATE INDEX contact_user_id_fk ON contact (user_id);";
        $this->execute($q);
    }

    public function down()
    {
        echo "m161214_132735_contact cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}

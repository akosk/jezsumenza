<?php

use yii\db\Schema;
use yii\db\Migration;

class m150607_202554_foreign_key_fix extends Migration
{
    public function up()
    {
        $q="ALTER TABLE `lunch_choice`
DROP FOREIGN KEY `lunch_choice_ibfk_2`,
ADD FOREIGN KEY (`lunch_menu_id`) REFERENCES `lunch_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE";
        $this->execute($q);

        $q="ALTER TABLE `lunch_menu`
ADD UNIQUE `letter_date` (`letter`, `date`);";
        $this->execute($q);
    }

    public function down()
    {
        echo "m150607_202554_foreign_key_fix cannot be reverted.\n";

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

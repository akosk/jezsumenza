<?php

use yii\db\Schema;
use yii\db\Migration;

class m150507_074027_food_translate_delete extends Migration
{
    public function up()
    {
$q="ALTER TABLE `food_translation`
ADD FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE CASCADE ON UPDATE CASCADE";
        $this->execute($q);
    }

    public function down()
    {
        $q="ALTER TABLE `food_translation`
DROP FOREIGN KEY `food_translation_ibfk_1`";
        $this->execute($q);
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

<?php

use yii\db\Schema;
use yii\db\Migration;

class m151007_103005_alter_gate_event_foreign_key extends Migration
{
    public function up()
    {
        $q = "
ALTER TABLE `gate_event`
DROP FOREIGN KEY `gate_event_ibfk_1`,
ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
";
        $this->execute($q);
        $q = "
ALTER TABLE `lunch_choice`
DROP FOREIGN KEY `lunch_choice_ibfk_1`,
ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
";
        $this->execute($q);
        $q = "
ALTER TABLE `lunch_right`
DROP FOREIGN KEY `lunch_right_ibfk_1`,
ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT";
        $this->execute($q);
        $q = "
ALTER TABLE `payment`
DROP FOREIGN KEY `payment_ibfk_1`,
ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT";
        $this->execute($q);
    }

    public function down()
    {
        echo "m151007_103005_alter_gate_event_foreign_key cannot be reverted.\n";

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

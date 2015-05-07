<?php

use yii\db\Schema;
use yii\db\Migration;

class m150507_142654_gate_event extends Migration
{
    public function up()
    {
$q="CREATE TABLE `gate_event` (
  `user_id` int(11) NOT NULL,
  `gate` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  KEY `user_id` (`user_id`),
  CONSTRAINT `gate_event_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;";
        $this->execute($q);
    }

    public function down()
    {
        $q="DROP TABLE `gate_event`;";
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

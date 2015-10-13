<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.05.26.
 * Time: 6:32
 */

namespace app\components;

use Exception;
use yii\helpers\VarDumper;
use yii\log\DbTarget as BaseDbTarget;

class DbTarget extends BaseDbTarget
{

    public function export()
    {
        $tableName = $this->db->quoteTableName($this->logTable);
        $sql = "INSERT INTO $tableName ([[level]], [[category]], [[log_time]], [[prefix]], [[message]], [[user_id]])
                VALUES (:level, :category, :log_time, :prefix, :message, :user_id)";
        $command = $this->db->createCommand($sql);
        foreach ($this->messages as $message) {
            list($text, $level, $category, $timestamp) = $message;
            if (!is_string($text)) {
                $text = VarDumper::export($text);
            }

            try {
                if (\Yii::$app->hasProperty('user')) {
                    $user = \Yii::$app->user;
                }

                $id = $user ? $user->id : '-';
                $prefix = $user ? $this->getMessagePrefix($message) : '-';
                $values = [
                    ':level'    => $level,
                    ':category' => $category,
                    ':log_time' => $timestamp,
                    ':prefix'   => $prefix,
                    ':message'  => $text,
                    ':user_id'  => $id,
                ];
                $result = $command->bindValues($values)->execute();
            } catch (Exception $e) {
                echo "Hiba a logolás során:" . $e->getMessage();
            }
        }
    }
}
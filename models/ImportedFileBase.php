<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "imported_file".
 *
 * @property integer $id
 * @property string $filename
 * @property string $create_time
 */
class ImportedFileBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'imported_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['filename', 'create_time'], 'required'],
            [['create_time'], 'safe'],
            [['filename'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Filename',
            'create_time' => 'Create Time',
        ];
    }
}

<?php

namespace app\models;


class Payment extends PaymentBase{


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'year' => 'Év',
            'month' => 'Hónap',
            'amount' => 'Összeg',
            'create_time' => 'Create Time',
        ];
    }


}
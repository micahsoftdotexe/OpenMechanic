<?php

namespace app\models;

use Yii;

class NotesForm extends yii\base\Model
{
    public $note;
    public $workorder_id;
    public function rules()
    {
        return [
            [['note', 'workorder_id'], 'required'],
        ];
    }
}
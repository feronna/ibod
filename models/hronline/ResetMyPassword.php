<?php

namespace app\models\hronline;

use Yii;
use yii\base\Model;
use app\models\hronline\JStrengthValidator;

/**
 * This is the model class for table " ".
 *
 * @property string $old_pass
 * @property string $new_pass1
 * @property string $new_pass2
 */
class ResetMyPassword extends Model
{
    public $username;
    public $old_pass;
    public $new_pass1;
    public $new_pass2;

    public function rules()
    {
        return [
            [['old_pass','new_pass1','new_pass2'], 'required','message'=>'Ruang ini adalah mandatori.'],
            [['old_pass','new_pass1','new_pass2'], 'string','max'=>20],
            [['new_pass1','new_pass2'], JStrengthValidator::className(), 'preset'=>'normal', 'userAttribute'=>'username'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Nama',
            'old_pass' => 'Katalaluan Lama',
            'new_pass1' => 'Katalaluan Baru',
            'new_pass2' => 'Katalaluan Baru',
        ];
    }
}

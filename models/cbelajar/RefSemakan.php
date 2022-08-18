<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hrd.cb_ref_semakan".
 *
 * @property int $id
 * @property string $syarat
 * @property string $syarat_id
 * @property int $status
 * @property string $checking
 * @property string $ans_char
 * @property int $ans_no
 * @property string $jenis
 * @property string $cb
 */
class RefSemakan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_ref_semakan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['syarat', 'checking'], 'string'],
            [['status', 'ans_no'], 'integer'],
            [['syarat_id', 'cb'], 'string', 'max' => 30],
            [['ans_char', 'jenis'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'syarat' => 'Syarat',
            'syarat_id' => 'Syarat ID',
            'status' => 'Status',
            'checking' => 'Checking',
            'ans_char' => 'Ans Char',
            'ans_no' => 'Ans No',
            'jenis' => 'Jenis',
            'cb' => 'Cb',
        ];
    }
}

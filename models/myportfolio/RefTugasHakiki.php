<?php

namespace app\models\myportfolio;

use Yii;

/**
 * This is the model class for table "myportfolio.ref_tugas_hakiki".
 *
 * @property int $id
 * @property string $tahap_tugas
 */
class RefTugasHakiki extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myjd_ref_tugas_hakiki';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahap_tugas'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tahap_tugas' => 'Tahap Tugas',
        ];
    }
}

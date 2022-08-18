<?php

namespace app\models\tatatertib_staf;

use Yii;

/**
 * This is the model class for table "tatatertib_staf.ref_bidang_kuasa".
 *
 * @property int $id
 * @property string $bidang_kuasa_nm
 */
class RefBidangKuasa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tertib_ref_bidang_kuasa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bidang_kuasa_nm'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bidang_kuasa_nm' => 'Bidang Kuasa Nm',
        ];
    }
}

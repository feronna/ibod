<?php

namespace app\models\tatatertib_staf;

use Yii;

/**
 * This is the model class for table "tatatertib_staf.ref_jenis_kesalahan".
 *
 * @property int $id
 * @property string $kesalahan_nm
 */
class RefJenisKesalahan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tertib_ref_jenis_kesalahan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kesalahan_nm'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kesalahan_nm' => 'Kesalahan Nm',
        ];
    }
}

<?php

namespace app\models\tatatertib_staf;

use Yii;

/**
 * This is the model class for table "tatatertib_staf.ref_jenis_hukuman".
 *
 * @property int $id
 * @property string $hukuman_nm
 */
class RefJenisHukuman extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tertib_ref_jenis_hukuman';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hukuman_nm'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hukuman_nm' => 'Hukuman Nm',
        ];
    }
}

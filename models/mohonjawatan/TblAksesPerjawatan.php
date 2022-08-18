<?php

namespace app\models\mohonjawatan;
use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "mohonjawatan.tbl_akses_perjawatan".
 *
 * @property int $id
 * @property string $icno
 * @property int $isActive 1--Active 0--inactive
 */
class TblAksesPerjawatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.mj_tbl_akses_perjawatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isActive'], 'integer'],
            [['icno'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'isActive' => 'Is Active',
        ];
    }
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
}

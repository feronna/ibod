<?php

namespace app\models\pengesahan;

use Yii;
use app\models\hronline\Tblprcobiodata;
/**
 * This is the model class for table "pengesahan.tbl_ahlimeeting".
 *
 * @property int $id
 * @property string $icno
 * @property int $category 1=akademik, 2=pentadbiran
 */
class TblAhlimeeting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
//        return 'pengesahan.tbl_ahlimeeting';
        return 'hrm.sah_tbl_ahlimeeting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category'], 'integer'],
            [['icno'], 'string', 'max' => 15],
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
            'category' => 'Category',
        ];
    }
    
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
}
}

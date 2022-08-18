<?php

namespace app\models\kontrak;

use Yii;
use app\models\hronline\Tblprcobiodata;
/**
 * This is the model class for table "kontrak.tbl_admin".
 *
 * @property int $id
 * @property string $icno
 * @property int $category 1=akademik, 2=pentadbiran
 */
class TblAdmin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.kontrak_tbl_admin';
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

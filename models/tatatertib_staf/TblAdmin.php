<?php

namespace app\models\tatatertib_staf;
use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "tatatertib_staf.tbl_admin".
 *
 * @property int $id
 * @property string $icno
 */
class TblAdmin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tertib_tbl_admin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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
        ];
    }
    
      public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
}

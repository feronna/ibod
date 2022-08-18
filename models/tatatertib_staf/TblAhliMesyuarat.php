<?php

namespace app\models\tatatertib_staf;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "tatatertib_staf.tbl_ahli_mesyuarat".
 *
 * @property int $id
 * @property string $icno
 */
class TblAhliMesyuarat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tertib_tbl_ahli_mesyuarat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
         //   [['icno'], 'string', 'max' => 15],
                [['icno'], 'safe'],
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

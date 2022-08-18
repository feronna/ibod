<?php

namespace app\models\portfolio;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "hrm.portfolio_ref_peringkat".
 *
 * @property int $int
 * @property int $no
 */
class RefPeringkat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.portfolio_ref_peringkat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'no' => 'No',
        ];
    }
    
         public function getPekerjaNm2() {

      // $kon = \app\models\hronline\Tblprcobiodata::findOne(['ICNO'=> $this->icno]);  
        return 'PERINGKAT -' . ' ' .$this->no . ' '. '(' .$this->nama . ')' ; 
        }
        
    
}

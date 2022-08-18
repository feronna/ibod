<?php

namespace app\models\elnpt;

use Yii;

use app\models\elnpt\TblPemberatAspek;

/**
 * This is the model class for table "hrm.elnpt_tbl_mrkh_aspek".
 *
 * @property int $id
 * @property int $lpp_id
 * @property int $aspek_id
 * @property double $skor
 * @property double $markah_pyd
 * @property double $markah_ppp
 * @property double $markah_ppk
 * @property double $markah_peer
 */
class TblMrkhAspek extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_mrkh_aspek';
    }
    
//    public static function primaryKey()
//    {
//        return ['lpp_id', 'aspek_id'];
//    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
//    public static function getDb()
//    {
//        return Yii::$app->get('db2');
//    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id', 'aspek_id', 'bhg_no'], 'integer'],
            [['skor', 'markah_pyd'], 'number'],
            [['markah_ppp', 'markah_ppk', 'markah_peer'], 'number', 'min' => 0],
            [['markah_ppp', 'markah_ppk'], 'checkMaxMarkah'],
//            [['markah_ppp', 'markah_ppk', 'markah_peer'], function ($attribute, $params) {
//                /* calculate min value */
//                $min = 123;
//                if ($this->$attribute > $min) {
//                    $this->addError($attribute, "Qty must be less than {$min}.");
//                }
//            }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lpp_id' => 'Lpp ID',
            'aspek_id' => 'Aspek ID',
            'skor' => 'Skor',
            'markah_pyd' => 'Markah Pyd',
            'markah_ppp' => 'Markah Ppp',
            'markah_ppk' => 'Markah Ppk',
            'markah_peer' => 'Markah Peer',
        ];
    }
    
    public function checkMaxMarkah($attribute, $params) {
        $lpp = TblMain::findOne(['lpp_id' => $this->lpp_id]);
        
        $gred = TblKumpGred::find()->where(['gred_id' => $lpp->gred_jawatan_id])->one();
        
        $dept = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->max('ref_kump_dept_id');
        
        $max = TblPemberatAspek::find()->where(['kump_dept_id' => $dept, 'kump_gred_id' => $gred->ref_kump_gred_id,
            'aspek_id' => $this->aspek_id])->one();
        
        if(!is_null($max)) {
        
            if($this->markah_ppp > $max->pemberat) {
                $this->addError($attribute, 'Markah lebih dari '.$max->pemberat);
            }

            if($this->markah_ppk > $max->pemberat) {
                $this->addError($attribute, 'Markah lebih dari '.$max->pemberat);
            }
            
            $this->addErrors($this->getErrors($attribute));
        }
        
        
    }
}

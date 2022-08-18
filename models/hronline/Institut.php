<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.institution".
 *
 * @property string $InstCd
 * @property string $InstNm
 * @property string $InstAddr1
 * @property string $InstAddr2
 * @property string $InstAddr3
 * @property string $InstPostcode
 * @property string $InstLocation
 * @property string $InstBranch
 * @property string $CityCd
 * @property string $StateCd
 * @property string $CountryCd
 * @property string $InstTypeCd
 */
class Institut extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.institution';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['InstCd'], 'required'],
            [['InstCd'], 'string', 'max' => 8],
            [['InstNm', 'InstAddr1', 'InstAddr2', 'InstAddr3', 'InstBranch'], 'string', 'max' => 255],
            [['InstPostcode'], 'string', 'max' => 5],
            [['InstLocation', 'CountryCd'], 'string', 'max' => 3],
            [['CityCd'], 'string', 'max' => 6],
            [['StateCd'], 'string', 'max' => 2],
            [['InstTypeCd'], 'string', 'max' => 4],
            [['InstCd'], 'unique','message'=>'ID telah wujud'],
            [['isActive'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'InstCd' => 'Inst Cd',
            'InstNm' => 'Inst Nm',
            'InstAddr1' => 'Inst Addr1',
            'InstAddr2' => 'Inst Addr2',
            'InstAddr3' => 'Inst Addr3',
            'InstPostcode' => 'Inst Postcode',
            'InstLocation' => 'Inst Location',
            'InstBranch' => 'Inst Branch',
            'CityCd' => 'City Cd',
            'StateCd' => 'State Cd',
            'CountryCd' => 'Country Cd',
            'InstTypeCd' => 'Inst Type Cd',
        ];
    }

    
    public function getStatus() {
        return $this->isActive ? "Aktif" : "Tidak Aktif";
    }
}

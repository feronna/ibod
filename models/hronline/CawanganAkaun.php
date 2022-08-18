<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.accountbranch".
 *
 * @property string $AccBranchCd
 * @property string $AccBranchNm
 * @property string $AccNmCd
 * @property string $AccBranchDesc
 * @property string $AccBranchAddr1
 * @property string $AccBranchAddr2
 * @property string $AccBranchAddr3
 * @property string $AccBranchPostcode
 * @property string $CityCd
 * @property string $StateCd
 * @property string $CountryCd
 * @property string $AccBranchTelNo
 * @property string $AccBranchFaxNo
 * @property string $AccBranchContPost
 * @property string $AccBranchContPerson
 * @property string $AccBranchStDt
 * @property string $AccBranchEndDt
 * @property string $AccBranchBankInd
 */
class CawanganAkaun extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    

    public static function tableName()
    {
        return 'hronline.accountbranch';
    }


    public function rules()
    {
        return [
            [['AccBranchCd'], 'required'],
            [['AccBranchCd'], 'string', 'max' => 20],
            [['AccBranchNm', 'AccBranchDesc', 'AccBranchAddr1', 'AccBranchAddr2', 'AccBranchAddr3', 'AccBranchBankInd'], 'string', 'max' => 255],
            [['AccNmCd'], 'string', 'max' => 4],
            [['AccBranchPostcode'], 'string', 'max' => 10],
            [['CityCd', 'StateCd', 'CountryCd'], 'string', 'max' => 5],
            [['AccBranchTelNo', 'AccBranchFaxNo', 'AccBranchContPost', 'AccBranchContPerson'], 'string', 'max' => 100],
            [['AccBranchStDt', 'AccBranchEndDt'], 'string', 'max' => 30],
            [['AccBranchCd'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'AccBranchCd' => 'Acc Branch Cd',
            'AccBranchNm' => 'Acc Branch Nm',
            'AccNmCd' => 'Acc Nm Cd',
            'AccBranchDesc' => 'Acc Branch Desc',
            'AccBranchAddr1' => 'Acc Branch Addr1',
            'AccBranchAddr2' => 'Acc Branch Addr2',
            'AccBranchAddr3' => 'Acc Branch Addr3',
            'AccBranchPostcode' => 'Acc Branch Postcode',
            'CityCd' => 'City Cd',
            'StateCd' => 'State Cd',
            'CountryCd' => 'Country Cd',
            'AccBranchTelNo' => 'Acc Branch Tel No',
            'AccBranchFaxNo' => 'Acc Branch Fax No',
            'AccBranchContPost' => 'Acc Branch Cont Post',
            'AccBranchContPerson' => 'Acc Branch Cont Person',
            'AccBranchStDt' => 'Acc Branch St Dt',
            'AccBranchEndDt' => 'Acc Branch End Dt',
            'AccBranchBankInd' => 'Acc Branch Bank Ind',
        ];
    }
}

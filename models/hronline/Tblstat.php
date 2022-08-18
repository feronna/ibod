<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.tbl_stat".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $table
 * @property string $idval
 * @property string $date_submit
 * @property int $status
 * @property string $checkBy
 * @property string $checkDate
 * @property string $desc
 * @property int $hrmisUpdate 0=Belum Kemaskini HRMIS, 1=Telah Kemaskini HRMIS
 * @property string $hrmisUpdateDt
 * @property string $hrmisUpdateId
 * @property string $hrmisUpdateDesc
 * @property string $hrmis_pic
 */
class Tblstat extends \yii\db\ActiveRecord
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
        return 'hronline.tbl_stat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_submit', 'checkDate', 'hrmisUpdateDt'], 'safe'],
            [['status', 'hrmisUpdate'], 'integer'],
            [['desc', 'hrmisUpdateDesc'], 'string'],
            [['ICNO', 'idval', 'checkBy', 'hrmisUpdateId'], 'string', 'max' => 12],
            [['table', 'hrmis_pic'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'table' => 'Table',
            'idval' => 'Idval',
            'date_submit' => 'Date Submit',
            'status' => 'Status',
            'checkBy' => 'Check By',
            'checkDate' => 'Check Date',
            'desc' => 'Desc',
            'hrmisUpdate' => 'Hrmis Update',
            'hrmisUpdateDt' => 'Hrmis Update Dt',
            'hrmisUpdateId' => 'Hrmis Update ID',
            'hrmisUpdateDesc' => 'Hrmis Update Desc',
            'hrmis_pic' => 'Hrmis Pic',
        ];
    }
}

<?php

namespace app\models\esticker;
use yii\data\ActiveDataProvider;

use Yii;

/**
 * This is the model class for table "{{%keselamatan.stc_kontraktor_in_out}}".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $reg_number
 * @property string $veh_color
 * @property string $veh_type
 * @property string $place
 * @property int $campus_id
 * @property string $check_in
 * @property string $check_out
 * @property string $created_by
 * @property string $flag 1=Aktif, 2=Senarai hitam, 0=Tidak Aktif
 * @property string $flag_open_reason
 * @property string $flag_created_at
 * @property string $flag_created_by
 * @property string $flag_closed_reason
 * @property string $flag_updated_at
 * @property string $flag_updated_by
 */
class TblRekodKontraktor extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%keselamatan.stc_kontraktor_in_out}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['place','campus_id','check_out'], 'required', 'message' => 'Ruang ini adalah mandatori.'],
            [['campus_id'], 'integer'],
            [['check_in', 'check_out', 'flag_created_at', 'flag_updated_at'], 'safe'],
            [['ICNO', 'created_by', 'flag_created_by', 'flag_updated_by'], 'string', 'max' => 12],
            [['reg_number'], 'string', 'max' => 15],
            [['veh_color'], 'string', 'max' => 30],
            [['veh_type'], 'string', 'max' => 10],
            [['place', 'flag_open_reason', 'flag_closed_reason'], 'string', 'max' => 255],
            [['flag'], 'string', 'max' => 1],
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
            'reg_number' => 'Reg Number',
            'veh_color' => 'Veh Color',
            'veh_type' => 'Veh Type',
            'place' => 'Destinasi',
            'campus_id' => 'Kampus',
            'check_in' => 'Tarikh/Masa Masuk',
            'check_out' => 'Tarikh/Masa Keluar',
            'created_by' => 'Created By',
            'flag' => 'Flag',
            'flag_open_reason' => 'Flag Open Reason',
            'flag_created_at' => 'Flag Created At',
            'flag_created_by' => 'Flag Created By',
            'flag_closed_reason' => 'Flag Closed Reason',
            'flag_updated_at' => 'Flag Updated At',
            'flag_updated_by' => 'Flag Updated By',
        ];
    }
    
    public function getPekerja() {
        return $this->hasOne(\app\models\Kontraktor\Kontraktor::className(), ['ICNO' => 'ICNO']);
    }
    
    public function getCampus() {
        return $this->hasOne(\app\models\hronline\Kampus::className(), ['campus_id' => 'campus_id']);
    }
    
    public function getDestinasi() {
        return $this->hasOne(\app\models\esticker\RefDestinasi::className(), ['id' => 'place']);
    }

    public function getPegawaiDaftar() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'created_by']);
    }

    public static function findGridDaftarKeluar() {
        $query = TblRekodKontraktor::find()->where(['flag' => 1])->orderBy(['check_in' => SORT_ASC]);


        $record = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $record;
    }
    
    public static function findGridDaftarKeluarOne($icno) {
        $query = TblRekodKontraktor::find()->where(['flag' => 1])->andWhere(['ICNO'=>$icno])->orderBy(['check_in' => SORT_ASC]);


        $record = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $record;
    }
    
    public static function findGridSenaraiHitam() {
        $query = TblRekodKontraktor::find()->where(['flag' => 2])->orderBy(['check_in' => SORT_ASC]);


        $record = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $record;
    }
    
    public static function findGridBelumDaftarKeluar() {
        $query = TblRekodKontraktor::find()->where(['flag' => 1])->orderBy(['check_in' => SORT_ASC]);


        $record = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $record;
    }
    
    public static function findGridSenaraiHitamOne($icno) {
        $query = TblRekodKontraktor::find()->where(['flag' => 2])->andWhere(['ICNO'=>$icno])->orderBy(['check_in' => SORT_ASC]);


        $record = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $record;
    }
}

<?php

namespace app\models\esticker;

use yii\data\ActiveDataProvider;
use Yii;

/**
 * This is the model class for table "keselamatan.stc_pelawat_in_out".
 *
 * @property int $id
 * @property string $ICNO
 * @property int $type 1=Pelawat,2=Pelancong,3=Kontraktor luar atau tidak berdaftar
 * @property string $reg_number
 * @property string $veh_color
 * @property string $veh_type
 * @property string $reason
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
class TblRekodPelawat extends \yii\db\ActiveRecord {

    public $CONm, $COOffTelNo;

    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.stc_pelawat_in_out';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['type', 'reason', 'place', 'check_out', 'campus_id'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['type', 'campus_id'], 'integer'],
            [['CONm', 'COOffTelNo', 'check_in', 'check_out', 'flag_created_at', 'flag_updated_at'], 'safe'],
            [['ICNO', 'created_by', 'flag_created_by', 'flag_updated_by'], 'string', 'max' => 12],
            [['reg_number'], 'string', 'max' => 15],
            [['veh_color'], 'string', 'max' => 30],
            [['veh_type'], 'string', 'max' => 10],
            [['reason', 'place', 'flag_open_reason', 'flag_closed_reason'], 'string', 'max' => 255],
            [['flag'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'type' => 'Type',
            'reg_number' => 'Reg Number',
            'veh_color' => 'Veh Color',
            'veh_type' => 'Veh Type',
            'reason' => 'Reason',
            'place' => 'Place',
            'campus_id' => 'Campus ID',
            'check_in' => 'Check In',
            'check_out' => 'Check Out',
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

    public function getPelawat() {
        return $this->hasOne(\app\models\esticker\TblPelawat::className(), ['ICNO' => 'ICNO']);
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
        $query = TblRekodPelawat::find()->where(['flag' => 1])->orderBy(['check_in' => SORT_ASC]);


        $record = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $record;
    }
    
    public static function findGridDaftarKeluarOne($icno) {
        $query = TblRekodPelawat::find()->where(['flag' => 1])->andWhere(['ICNO'=>$icno])->orderBy(['check_in' => SORT_ASC]);


        $record = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $record;
    }
    
    public static function findGridSenaraiHitam() {
        $query = TblRekodPelawat::find()->where(['flag' => 2])->orderBy(['check_in' => SORT_ASC]);


        $record = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $record;
    }
    
    public static function findGridSenaraiHitamOne($icno) {
        $query = TblRekodPelawat::find()->where(['flag' => 2])->andWhere(['ICNO'=>$icno])->orderBy(['check_in' => SORT_ASC]);


        $record = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $record;
    }

}

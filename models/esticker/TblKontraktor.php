<?php

namespace app\models\esticker;

use Yii;

/**
 * This is the model class for table "{{%kontraktor.vw_pelekat_hr}}".
 *
 * @property string $apsu_suppid
 * @property string $apsu_lname
 * @property string $apsu_status
 * @property string $apsu_address1
 * @property string $apsu_address2
 * @property string $apsu_address3
 * @property string $apsu_phone
 * @property string $apsu_email
 * @property string $tarikhmulasah
 * @property string $tarikhtamatsah
 */
class TblKontraktor extends \yii\db\ActiveRecord {

    public static function getDb() {
        return Yii::$app->get('db15');
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%kontraktor.vw_pelekat_hr}}';
    }
 
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['apsu_suppid'], 'required'],
            [['apsu_lname', 'apsu_address1', 'apsu_address2', 'apsu_address3'], 'string'],
            [['apsu_suppid', 'apsu_phone'], 'string', 'max' => 50],
            [['apsu_status'], 'string', 'max' => 1],
            [['apsu_email'], 'string', 'max' => 250],
            [['tarikhmulasah', 'tarikhtamatsah'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'apsu_suppid' => 'Apsu Suppid',
            'apsu_lname' => 'Apsu Lname',
            'apsu_status' => 'Apsu Status',
            'apsu_address1' => 'Apsu Address1',
            'apsu_address2' => 'Apsu Address2',
            'apsu_address3' => 'Apsu Address3',
            'apsu_phone' => 'Apsu Phone',
            'apsu_email' => 'Apsu Email',
            'tarikhmulasah' => 'Tarikhmulasah',
            'tarikhtamatsah' => 'Tarikhtamatsah',
        ];
    }
    
    public static function primaryKey()
    {
        return ["apsu_suppid"];
    }

    public function getKenderaan() {
        return $this->hasMany(\app\models\esticker\TblStickerKontraktor::className(), ['id_kontraktor' => 'apsu_suppid']);
    }

    public function Pelekat() {
        return \app\models\esticker\TblPelekatKenderaanKontraktor::find()->where(['id_kontraktor' => $this->apsu_suppid])->orderBy(['mohon_date' => SORT_DESC])->all();
    }

    public function findStickerRate($id) {
        $model = TblStickerKontraktor::findOne(['id' => $id]);
        if ($model->rel_owner_user == 'DIRI SENDIRI') {
            $max_veh = TblPelekatKenderaan::findPaymentRate('KENDERAAN PEKERJA');
            return $max_veh->amount;
        } else {
            $max_veh = TblPelekatKenderaan::findPaymentRate('KENDERAAN SYARIKAT');
            if (in_array($model->veh_type, ['LR', 'VN','KR'])) {
                return $max_veh->bas_lori_rate;
            } else {
                return $max_veh->amount;
            }
        }
    }
    
    public function getJenisKontraktor($id) {
        $model = \app\models\Kontraktor\SyarikatKontraktor::find()->where(['apsu_suppid' => $id])->one();
    
        if($model){
            return $model->jenis? $model->jenis->jenis_desc:'Tiada Maklumat';
        }else{
            return '';
        }
    }
    
    public function getJumlahPekerja($id) {
        return \app\models\Kontraktor\Kontraktor::find()->where(['id_kontraktor' => $id])->andWhere(['Status'=>1])->count();
    }
    
}

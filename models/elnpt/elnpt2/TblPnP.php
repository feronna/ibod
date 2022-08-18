<?php

namespace app\models\elnpt\elnpt2;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v2_tbl_pnp".
 *
 * @property int $id
 * @property int $id_pnp
 * @property string $lpp_id
 * @property int $bil_pelajar
 * @property string $status_kursus
 * @property int $jam_syarahan
 * @property int $jam_tutorial
 * @property int $jam_amali
 * @property string $status_fail
 * @property string $semester
 * @property string $skop_tugas
 * @property string $status_pengendalian
 * @property string $penglibatan
 * @property int $seksyen
 */
class TblPnP extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v2_tbl_pnp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pnp', 'lpp_id', 'bil_pelajar', 'jam_syarahan', 'jam_tutorial', 'jam_amali', 'seksyen', 'hasTech'], 'integer'],
            [['seksyen', 'hasTech'], 'default', 'value' => 0],
            [['status_kursus'], 'string', 'max' => 10],
            [['status_fail', 'semester', 'skop_tugas', 'penglibatan'], 'string', 'max' => 20],
            [['status_pengendalian'], 'string', 'max' => 50],
            [['jam_syarahan', 'jam_tutorial', 'jam_amali'], 'integer', 'min' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_pnp' => 'Id Pnp',
            'lpp_id' => 'Lpp ID',
            'bil_pelajar' => 'Bil Pelajar',
            'status_kursus' => 'Status Kursus',
            'jam_syarahan' => 'Jam Syarahan',
            'jam_tutorial' => 'Jam Tutorial',
            'jam_amali' => 'Jam Amali',
            'status_fail' => 'Status Fail',
            'semester' => 'Semester',
            'skop_tugas' => 'Skop Tugas',
            'status_pengendalian' => 'Status Pengendalian',
            'penglibatan' => 'Penglibatan',
            'seksyen' => 'Seksyen',
            'hasTech' => 'Berasaskan teknologi/ transformatif/ inovasi',
        ];
    }

    public function getLpp()
    {
        return $this->hasMany(\app\models\elnpt\TblMain::className(), ['lpp_id' => 'lpp_id']);
    }

    public function getPengajaran()
    {
        return $this->hasOne(TblPengajaranPembelajaran::className(), ['id' => 'id_pnp']);
    }

    public function getRekodPengajaran($id)
    {
        $auto = \app\models\elnpt\TblPengajaran::find()->where(['AutoId' => $this->id_pnp])->andWhere(['NOKP' => $id])->one();
        $manual = TblPengajaranPembelajaran::find()->where(['id' => $this->id_pnp])->one();
        if (!empty($auto)) {
            return $auto;
        } elseif (!empty($manual)) {
            return $manual;
        } else {
            return null;
        }
    }

    public function getStatusRekodPengajaran($id)
    {
        $auto = \app\models\elnpt\TblPengajaran::find()->where(['AutoId' => $this->id_pnp])->andWhere(['NOKP' => $id])->one();
        $manual = TblPengajaranPembelajaran::find()->where(['id' => $this->id_pnp])->one();
        if (!empty($auto)) {
            return 'Auto';
        } elseif (!empty($manual)) {
            return 'Manual';
        } else {
            return null;
        }
    }
}

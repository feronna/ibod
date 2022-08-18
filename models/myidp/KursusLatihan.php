<?php

namespace app\models\myidp;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\hronline\Campus;
use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "myidp.kursusLatihan".
 *
 * @property int $kursusLatihanID
 * @property string $tajukLatihan
 * @property string $penggubalModul
 * @property string $tahunTawaran
 * @property string $kategoriJawatanID
 * @property int $klusterID
 */
class KursusLatihan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return '{{%hrd.idp_kursusLatihan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penggubalModul', 'tajukLatihan', 'klusterID', 'kompetensi', 'kategori_latihan', 'jenisPenganjur', 'namaPenganjur', 'tahunTawaran', 'kategoriJawatanID'], 
            'required', 
            'message' => 'Ruangan ini adalah mandatori', 
            'on'=>'impak'],
            [['penggubalModul', 'tajukLatihan', 'klusterID', 'kompetensi', 'kategori_latihan', 'tahunTawaran', 'kategoriJawatanID'], 
            'required', 
            'message' => 'Ruangan ini adalah mandatori', 
            'on'=>'kursus-baru'],
            [['tajukLatihan', 'sinopsisKursus'], 'string'],
            [['klusterID', 'kompetensi', 'permohonanID', 'kursusID', 'vcsl_kod_latihan', 'dept_ID', 'kategori_latihan'], 'integer'],
            [['penggubalModul', 'namaPenganjur'], 'string', 'max' => 100],
            [['tahunTawaran'], 'string', 'max' => 4],
            [['kategoriJawatanID', 'jenisLatihanID', 'statusKursusLatihan', 'unitBertanggungjawab', 'jenisPenganjur'], 'string', 'max' => 25],
            [['kursusImpakTinggi'], 'string', 'max' => 5],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kursusLatihanID' => 'Kursus Latihan ID',
            'tajukLatihan' => 'Tajuk Latihan',
            'penggubalModul' => 'Penggubal Modul',
            'tahunTawaran' => 'Tahun Tawaran',
            'kategoriJawatanID' => 'Kategori Jawatan ID',
            'klusterID' => 'Kluster ID',
            'jenisLatihanID' => 'Jenis Latihan ID',
            'sinopsisKursus' => 'Sinopsis Kursus',
            'statusKursusLatihan' => 'Status Kursus Latihan',
            'kursusImpakTinggi' => 'Kursus Impak Tinggi',
            'unitBertanggungjawab' => 'Unit Bertanggungjawab',
            'kompetensi' => 'Kompetensi',
            'permohonanID' => 'Permohonan ID',
            'kursusID' => 'Kursus ID',
            'vcsl_kod_latihan' => 'Vcsl Kod Latihan',
            'dept_ID' => 'Dept ID',
            'jenisPenganjur' => Yii::t('app', 'Jenis Penganjur'),
            'namaPenganjur' => Yii::t('app', 'Nama Penganjur'),
        ];
    }

    /** Relation **/
    // KursusLatihan[kategoriJawatanID] == IdpKategoriJawatan[kategoriJawatanID] 
    public function getKategoriJawatan()
    {
        return $this->hasOne(IdpKategoriJawatan::className(), ['kategoriJawatanID' => 'kategoriJawatanID']);
    }

    /** Relation **/
    // KursusLatihan[KampusID] == IdpCampus[campus_id] 
    public function getCampusName()
    {
        return $this->hasOne(Campus::className(), ['campus_id' => 'kampusID']);
    }

    /** Relation **/
    // KursusLatihan[kategoriJawatanID] == IdpKategoriJawatan[kategoriJawatanID] 
    public function getPenceramah()
    {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'penceramahID']);
    }

    public function getKepakaran()
    {
        return $this->hasMany(\app\models\hronline\Tblbidangkepakaran::className(), ['ICNO' => 'penceramahID']);
    }

    public function getKlusterKursus()
    {
        return $this->hasOne(KlusterKursus::className(), ['kluster_id' => 'klusterID']);
    }

    public function getKompetensiii()
    {
        return $this->hasOne(Kategori::className(), ['kategori_id' => 'kompetensi']);
    }

    public function getSasarann()
    {
        return $this->hasMany(SiriLatihan::className(), ['kursusLatihanID' => 'kursusLatihanID']);
    }

    public function getMohonmata()
    {
        return $this->hasOne(PermohonanMataIdpIndividu::className(), ['permohonanID' => 'permohonanID']);
    }

    /** Function to list out 'senarai kursus/latihan for 'urusetiaLatihan' based on current year **/
    public function getSenaraiKursus()
    { //uncalled function

        //get current year
        $currentYear = date('Y');

        $senaraiKursusDP = new ActiveDataProvider([
            'query' => KursusLatihan::find()->where(['tahunTawaran' => $currentYear]),
            'pagination' => ['pageSize' => 30,],
        ]);

        return $senaraiKursusDP;
    }

    public function getYearsList()
    {
        $currentYear = date('Y');
        $yearAdvance = date("Y", strtotime("+1 year"));
        $yearsRange = range($currentYear, $yearAdvance);
        return array_combine($yearsRange, $yearsRange);
    }

    public function getDeptList()
    {
        $modelDept = Department::find()->all();

        $list = ArrayHelper::map($modelDept, 'id', function ($model) {
            $a = $model['fullname'] . ' (' . $model['shortname'] . ')';
            return $a;
        });

        return $list;

        
    }

    public function CheckSiri($kursusLatihanID)
    {

        $statusSiri = '1';

        //get current user ID
        $id = Yii::$app->user->getId();
        $model = Tblprcobiodata::find()->where(['ICNO' => $id])->one();

        //get 'gredjawatan' from database
        $gredJawatan = $model->gredJawatan;
        $tahap = $model->tahapKhidmat;

        //        $check = SiriLatihan::find()
        //                ->where(['kursusLatihanID' => $kursusLatihanID])
        //                ->all();

        $check = KursusSasaran::find()
            ->joinWith('sasaran')
            ->where(['kursusLatihanID' => $kursusLatihanID])
            ->andWhere("gredJawatanID = $gredJawatan and tahap = $tahap")
            ->all();

        foreach ($check as $checkSiri) {

            if ($checkSiri->sasaran->statusSiriLatihan == 'SEDANG BERJALAN') {
                $statusSiri = '2';
            } elseif ($checkSiri->sasaran->statusSiriLatihan == 'ACTIVE') {

                if (SiriLatihan::checkKuota($checkSiri->siriLatihanID) >= $checkSiri->sasaran->kuota) {
                    $statusSiri = '2';
                } else {
                    $statusSiri = '1';
                    break;
                }
            }
        }

        return $statusSiri;
    }

    public function CheckPohon($kursusLatihanID)
    {

        $userID = Yii::$app->user->getId();

        $cpohon = PermohonanLatihan::find()
            ->where(['kursusLatihanID' => $kursusLatihanID])
            ->andWhere(['staffID' => $userID, 'YEAR(tarikhPermohonan)' => date('Y')])
            ->one();

        if ($cpohon) {

            if ($cpohon->caraPermohonan == 'jemputan') {
                return 1;
            } elseif ($cpohon->caraPermohonan == 'sendiriMohon') {
                return 2;
            }
        } else {
            return 0;
        }
    }

    public function CheckHadir($kursusLatihanID)
    {

        $userID = Yii::$app->user->getId();

        $checkPeserta = Kehadiran::find()
            ->joinWith('sasaran9.sasaran4.sasaran3')
            ->where(['staffID' => $userID, 'YEAR(tarikhMasa)' => date('Y')])
            ->andWhere(['idp_kursusLatihan.kursusLatihanID' => $kursusLatihanID])
            ->one();

        if ($checkPeserta) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getBorang()
    {
        return $this->hasMany(BorangPenilaianLatihan::className(), ['kursusLatihanID' => 'kursusLatihanID']);
    }

    public function getKompetensii()
    {

        $a = "TIADA DATA";

        if ($this->kompetensi != 0) {

            if ($this->kompetensi == 1) {
                $a = '<span class="label label-default">UMUM</span>';
            } elseif ($this->kompetensi == 3) {
                $a = '<span class="label label-danger">TERAS</span>';
            } elseif ($this->kompetensi == 4) {
                $a = '<span class="label label-primary">ELEKTIF</span>';
            } elseif ($this->kompetensi == 5) {
                $a = '<span class="label label-success">TERAS UNIVERSITI</span>';
            } elseif ($this->kompetensi == 6) {
                $a = '<span class="label label-info">TERAS SKIM</span>';
            } elseif ($this->kompetensi == 7) {
                $a = '<span class="label label-warning">IMPAK TINGGI</span>';
            }

            return $a;
        }
        //        else {
        //            //$a = '<span class="label label-success">BUKAN SASARAN</span>';
        //            $a = Html::button('UBAH', ['value' => 'ubah-jenis-kursus?slotID='.$this->slotID.'&peserta='.$this->staffID, 'class' => 'mapBtn btn-sm btn-danger btn-block']);
        //
        //            return $a;
        //            
        //        }    
    }

    public function getJenisKursus()
    {

        if ($this->jenisLatihanID == 'latihanDalaman') {
            return '<span class="label label-success">DALAMAN</span>';
        } elseif ($this->jenisLatihanID == 'jfpiu') {
            return '<span class="label label-primary">JAFPIB</span>';
        } else {
            return " ";
        }
    }

    public function identifyJenis($kursusLatihanID)
    {

        $kursus = KursusLatihan::find()->where(['kursusLatihanID' => $kursusLatihanID])->one();

        if ($kursus->permohonanID != NULL || $kursus->kursusID != NULL) {
            return '<span class="label label-primary">PERMOHONAN MATA IDP</span>';
        } else {
            if ($kursus->jenisLatihanID == 'latihanDalaman') {
                return '<span class="label label-success">KURSUS DALAMAN</span>';
            } elseif ($kursus->jenisLatihanID == 'jfpiu') {
                return '<span class="label label-primary">PERMOHONAN MATA IDP</span>';
            }
        }
    }

    public function getPengemaskini()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'updated_by']);
    }
}

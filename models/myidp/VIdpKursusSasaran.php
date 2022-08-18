<?php

namespace app\models\myidp;

use Yii;
use app\models\myidp\Idp;
use app\models\myidp\VIdpSenaraiKursus;
use app\models\hronline\GredJawatan;

/**
 * This is the model class for table "idp.v_idp_kursus_sasaran".
 *
 * @property int $sasaran_id
 * @property int $kursus_id iid
 * @property int $gredjawatan view_jawatan
 * @property int $kategori_id r_kategori
 * @property int $tahap r_tahap
 * @property int $kumpulan
 */
class VIdpKursusSasaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        // return 'idp.v_idp_kursus_sasaran';
        return 'hrd.v_idp_kursus_sasaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kursus_id', 'gredjawatan', 'kategori_id', 'tahap', 'kumpulan'], 'integer'],
            //[['kursus_id', 'gredjawatan', 'kategori_id', 'tahap'],'required', 'message' => 'Ruangan ini adalah mandatori'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sasaran_id' => 'Sasaran ID',
            'kursus_id' => 'Kursus ID',
            'gredjawatan' => 'Gredjawatan',
            'kategori_id' => 'Kategori ID',
            'tahap' => 'Tahap',
            'kumpulan' => 'Kumpulan',
        ];
    }

    /** Relation **/
    public function getSasaran()
    {
        return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id' => 'kursus_id']);
    }

    /** Relation **/
    public function getJawatan(){
        return $this->hasOne(GredJawatan::className(), ['id'=>'gredjawatan']);
    }
}

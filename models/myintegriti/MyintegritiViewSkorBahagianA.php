<?php

namespace app\models\myintegriti;

use Yii;

/**
 * This is the model class for table "myintegriti.view_skor_bahagian_a".
 *
 * @property string $icno
 * @property int $id_penilaian
 * @property string $code
 * @property int $jum_soalan
 * @property string $penilaian
 * @property int $full_mark
 * @property string $skor
 */
class MyintegritiViewSkorBahagianA extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.itg_view_skor_bahagian_a';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penilaian', 'jum_soalan', 'full_mark', 'tahun'], 'integer'],
            [['penilaian', 'skor'], 'number'],
            [['icno'], 'string', 'max' => 14],
            [['code'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'icno' => 'Icno',
            'id_penilaian' => 'Id Penilaian',
            'code' => 'Code',
            'jum_soalan' => 'Jum Soalan',
            'penilaian' => 'Penilaian',
            'full_mark' => 'Full Mark',
            'skor' => 'Skor',
        ];
    }
		
	public function totalSkor($icno,$tahun,$id_penilaian,$domain) {
		$skor=0;

        //$modelskor = self::find()->where(['icno' => $icno, 'tahun' => $tahun, 'id_penilaian' => $id_penilaian, 'code' => $domain]);
		
		$modelskor = MyintegritiViewSkorBahagianA::find()->where(['icno' => $icno, 'tahun' => $tahun, 'id_penilaian' => $id_penilaian, 'code' => $domain])->one();
		
		if($modelskor)
		{
			$skor = $modelskor->skor;
		}

        return $skor;
    }
	
	public function indeksIntegriti($icno,$tahun,$id_penilaian) {
		$skorA=0;
		$skorB=0;
		$skorH=0;
		
		$purata_amanah=0;
		$purata_bijaksana=0;
		$purata_hemah=0;
		
		$modelAmanah = MyintegritiViewSkorBahagianA::find()->where(['icno' => $icno, 'tahun' => $tahun, 'id_penilaian' => $id_penilaian, 'code' => 'A'])->one();
		
		if($modelAmanah)
		{
			$skorA = $modelAmanah->skor;
		}
		
		$modelBijaksana = MyintegritiViewSkorBahagianA::find()->where(['icno' => $icno, 'tahun' => $tahun, 'id_penilaian' => $id_penilaian, 'code' => 'B'])->one();
		
		if($modelBijaksana)
		{
			$skorB = $modelBijaksana->skor;
		}
		
		$modelHemah = MyintegritiViewSkorBahagianA::find()->where(['icno' => $icno, 'tahun' => $tahun, 'id_penilaian' => $id_penilaian, 'code' => 'H'])->one();
		
		if($modelHemah)
		{
			$skorH = $modelHemah->skor;
		}
		
		$purata_amanah=$skorA * 0.50;
		$purata_bijaksana=$skorB * 0.30;
		$purata_hemah=$skorH * 0.20;
		

        return round(($purata_amanah+$purata_bijaksana+$purata_hemah)/5*100)."%";
    }
}

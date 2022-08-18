<?php

namespace app\models\lppums;

use Yii;

/**
 * This is the model class for table "hronline.v_cf_mata_akhir".
 *
 * @property int $kategori
 * @property int $susunan
 * @property int $kodkumpulan
 * @property string $namakumpulan
 * @property string $icno
 * @property double $layak2011
 * @property double $mata2011
 * @property double $jum2011
 * @property double $cf2012
 * @property double $layak2012
 * @property double $mata2012
 * @property double $jum2012
 * @property double $cf2013
 * @property double $layak2013
 * @property double $mata2013
 * @property double $jum2013
 * @property double $cf2014
 * @property double $layak2014
 * @property double $mata2014
 * @property double $jum2014
 * @property double $cpd2014
 * @property double $cf2015
 * @property double $layak2015
 * @property double $mata2015
 * @property double $jum2015
 * @property double $cf2016
 * @property double $layak2016
 * @property double $mata2016
 * @property double $jum2016
 * @property double $cf2017
 * @property double $layak2017
 * @property double $mata2017
 * @property double $jum2017
 * @property double $cf2018
 * @property double $layak2018
 * @property double $mata2018
 * @property double $jum2018
 * @property double $cf2019
 * @property double $layak2019
 * @property double $mata2019
 * @property double $jum2019
 * @property string $last_update
 */
class TblMataAkhir extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.v_cf_mata_akhir';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kategori', 'susunan', 'kodkumpulan'], 'integer'],
            [['icno'], 'required'],
            [['layak2011', 'mata2011', 'jum2011', 'cf2012', 'layak2012', 'mata2012', 'jum2012', 'cf2013', 'layak2013', 'mata2013', 'jum2013', 'cf2014', 'layak2014', 'mata2014', 'jum2014', 'cpd2014', 'cf2015', 'layak2015', 'mata2015', 'jum2015', 'cf2016', 'layak2016', 'mata2016', 'jum2016', 'cf2017', 'layak2017', 'mata2017', 'jum2017', 'cf2018', 'layak2018', 'mata2018', 'jum2018', 'cf2019', 'layak2019', 'mata2019', 'jum2019'], 'number'],
            [['last_update'], 'safe'],
            [['namakumpulan'], 'string', 'max' => 300],
            [['icno'], 'string', 'max' => 36],
            [['icno'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kategori' => 'Kategori',
            'susunan' => 'Susunan',
            'kodkumpulan' => 'Kodkumpulan',
            'namakumpulan' => 'Namakumpulan',
            'icno' => 'Icno',
            'layak2011' => 'Layak2011',
            'mata2011' => 'Mata2011',
            'jum2011' => 'Jum2011',
            'cf2012' => 'Cf2012',
            'layak2012' => 'Layak2012',
            'mata2012' => 'Mata2012',
            'jum2012' => 'Jum2012',
            'cf2013' => 'Cf2013',
            'layak2013' => 'Layak2013',
            'mata2013' => 'Mata2013',
            'jum2013' => 'Jum2013',
            'cf2014' => 'Cf2014',
            'layak2014' => 'Layak2014',
            'mata2014' => 'Mata2014',
            'jum2014' => 'Jum2014',
            'cpd2014' => 'Cpd2014',
            'cf2015' => 'Cf2015',
            'layak2015' => 'Layak2015',
            'mata2015' => 'Mata2015',
            'jum2015' => 'Jum2015',
            'cf2016' => 'Cf2016',
            'layak2016' => 'Layak2016',
            'mata2016' => 'Mata2016',
            'jum2016' => 'Jum2016',
            'cf2017' => 'Cf2017',
            'layak2017' => 'Layak2017',
            'mata2017' => 'Mata2017',
            'jum2017' => 'Jum2017',
            'cf2018' => 'Cf2018',
            'layak2018' => 'Layak2018',
            'mata2018' => 'Mata2018',
            'jum2018' => 'Jum2018',
            'cf2019' => 'Cf2019',
            'layak2019' => 'Layak2019',
            'mata2019' => 'Mata2019',
            'jum2019' => 'Jum2019',
            'last_update' => 'Last Update',
        ];
    }
}

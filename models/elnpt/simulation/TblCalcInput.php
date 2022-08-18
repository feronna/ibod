<?php

namespace app\models\elnpt\simulation;

use Yii;
use yii\base\Model;

class TblCalcInput extends Model
{
    public $jawatan;
    public $fapi;
    public $peratusMax;
    public $bilpelajar;
    public $gred;
    public $isElaun;
    public $gugusan;
    public $sahsiah;
    public $pemberatK1;
    public $pemberatK2;
    public $pemberatK3;
    public $pemberatK4;

    public function rules()
    {
        return [
            [['gred', 'jawatan'], 'string'],
            [['isElaun', 'gugusan', 'fapi'], 'integer'],
            [[
                'gred', 'isElaun', 'gugusan',
                'pemberatK1', 'pemberatK2', 'pemberatK3', 'pemberatK4',
                'bilpelajar', 'peratusMax',
                'jawatan',
            ], 'required'],
            [['sahsiah', 'pemberatK4'], 'default', 'value' => 0],
            [['peratusMax'], 'default', 'value' => 1 / 3],
            [['pemberatK1'], 'default', 'value' => 40],
            [['pemberatK2'], 'default', 'value' => 40],
            [['pemberatK3'], 'default', 'value' => 20],
            [['bilpelajar'], 'default', 'value' => 50],
            [['sahsiah'], 'number', 'min' => 0, 'max' => 10],
            [['pemberatK1', 'pemberatK2', 'pemberatK3', 'pemberatK4'], 'number', 'min' => 0, 'max' => 100],
            [['peratusMax', 'bilpelajar'], 'number', 'min' => 0],
        ];
    }

    public function formName()
    {
        return 'TblCalcInput';
    }

    public function attributeLabels()
    {
        return [
            'peratusMax' => 'Peratus Maksimum Markah Boleh Melimpah Dari Hakiki',
            'gred' => 'Gred Jawatan',
            'isElaun' => 'Pentadbir Elaun',
            'gugusan' => 'Gugusan',
            'sahsiah' => 'Markah Sahsiah',
            'pemberatK1' => 'Pemberat',
            'pemberatK2' => 'Pemberat',
            'pemberatK3' => 'Pemberat',
            'pemberatK4' => 'Pemberat',
            'bilpelajar' => 'Saiz Kelas',
        ];
    }

    public function getGugusanLabel()
    {
        switch ($this->gugusan) {
            case 1:
                return 'SAINS';
            case 2:
                return 'SASTERA';
        }
    }

    public static function jawatanPentadbiran()
    {
        return [
            'DEKAN' => 5,
            'KETUA JABATAN' => 3,
            'KETUA PROGRAM' => 3,
            'NAIB CANSELOR' => 8,
            'PENGARAH' => 5,
            'PENYELARAS' => 3,
            'TIDAK BERKAITAN (BUKAN PENTADBIR)' => 1,
            'TIMBALAN DEKAN' => 5,
            'TIMBALAN NAIB CANSELOR' => 8,
            'TIMBALAN PENGARAH' => 5,
        ];
    }
}

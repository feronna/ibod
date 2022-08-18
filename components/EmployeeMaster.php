<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use app\models\grp\VwIntegrationGrp;
use app\models\grp\SubVwIntegrationGrp01;
use app\models\grp\SubVwIntegrationGrp02;
use app\models\grp\SubVwIntegrationGrp03;
use yii\helpers\VarDumper;

class EmployeeMaster extends Component
{

    public function EmployeeRegister($icno)
    {
        $url = "http://103.21.34.203:46908/STG/GRP/UMS/EmployeeMaster";
        $client = new Client();

        try {

            VarDumper::dump($this->Data($icno),10,true);

            $response = $client->post($url, [
                'header' => [
                    'Content-Type' => 'application/json',
                ],
                // 'json' => $this->StafData($icno),
                'json' => $this->Data($icno),
            ]);

            
            return json_decode($response->getBody());
        } catch (RequestException $e) {

            if ($e->hasResponse()) {
                if ($e->getResponse()->getstatusCode() == '404') {
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }
            }
        }

        //tambah sini function log simpan json data dan status
        

    }

    private function StafData($icno)
    {
        $jumlahIsteri = 0;
        $jumlahUnder18 = 0;
        $jumlahOver18 = 0;

        $model = VwIntegrationGrp::findOne(['ICNo' => $icno]);
        $isteri = SubVwIntegrationGrp01::findOne(['ICNO' => $icno]);
        $under18Child = SubVwIntegrationGrp02::findOne(['ICNO' => $icno]);
        $over18Child = SubVwIntegrationGrp03::findOne(['ICNO' => $icno]);

        if ($isteri) {
            $jumlahIsteri = $isteri->JUMLAH_ISTERI;
        }

        if ($under18Child) {
            $under18Child->jumlah;
        }

        if ($over18Child) {
            $over18Child->jumlah;
        }


        $array = [
            'Method' => 'EmployeePost',
            'GateWayName' => 'EmployeeRegister',
            'Attributes' => [
                'Attributes' => [
                    0 => [
                        'Attribute' => [
                            'Name' => 'Employee',
                            'Value' => [
                                'Employee' => [
                                    'Branch' => $model->Branch,
                                    'EmployeeID' => $model->EmployeeID, #often-changes
                                    'EmployeeName' => $model->EmployeeName,
                                    'DateOfBirth' => $model->DateOfBirth,
                                    'ICNo' => $model->ICNo,
                                    'Status' => 'Active', #often-changes //tukar dlm view tukar pg english #GRP (Further discussion)
                                    'Email' => $model->Email, 
                                    'HPNo' => $model->HPNo,
                                    'HomeNo' => $model->HomeNo,
                                    'Address1' => $model->Address1,
                                    'Address2' => $model->Address2,
                                    'City' => $model->City,
                                    'Country' => 'MY', //tukar dlm view = Ref //Corresponden Address (Malaysia Only)
                                    'PostalCode' => $model->PostalCode,
                                    'State' => $model->State,
                                    'EmployeeClass' => $model->EmployeeClass, #often-changes  //Tukar dlm view (Status Lantikan) dlm GRP cuma ada tetap saja
                                    'Department' => '000000', //Department = Ref (Shortname) #often-changes 
                                    'Position' => $model->Position, //GRED #often-changes 
                                    'WorkStartDate' => $model->WorkStartDate, #often-changes 
                                    'WorkEndDate' => $model->WorkEndDate, #often-changes 
                                    'BeneficiaryAccountNo' => $model->BeneficiaryAccountNo, //(Masih ada kosong)
                                    'BeneficiaryAccountName' => $model->BeneficiaryAccountName, //(Masih ada kosong)
                                    'BeneficiaryBankCode' => $model->BeneficiaryBankCode, //(Masih ada kosong) //REF Bank Code dgn GRP
                                    'MaritalStatus' => $model->MaritalStatus, // tukar dlm view = ENGLISH #often-changes 
                                    'SpouseName' => $model->SpouseName, //Isteri pertama #discuss
                                    'SpouseIcNo' => $model->SpouseIcNo, //Isteri pertama #discuss
                                    'SpouseTaxNo' => $model->SpouseTaxNo, //Isteri pertama #discuss
                                    'SpouseTaxOffice' => $model->SpouseTaxOffice,
                                    'GradeCode' => $model->GradeCode, //GRED #often-changes
                                    'SalaryGroup' => 'KS', //tukar dlm view Jobgroup KS | PP KUMPKHIDMAT #GRP #often-changes
                                    'PayGroup' => 'BULANAN', //tukar dlm view (SMBU - Pending) #GRP 
                                    'TaxNo' => $model->TaxNo, //perlu dwujudkan
                                    'TaxCategory' => $model->TaxCategory, //perlu dwujudkan #often-changes
                                    'BasicSalary' => $model->BasicSalary, //(SMBU) gaji pokok #often-changes
                                    'IncrementMonth' => $model->IncrementMonth, //KGT #often-changes
                                    'PayPattern' => 'STD1', //Pending for discussion (Team Finance) #GRP
                                    'ConfirmedDate' => $model->ConfirmedDate, //Tarikh Pengesahan utk staff tetap #often-changes
                                    'PromotionDate' => $model->PromotionDate, //Kenaikan Pangkat #often-changes
                                    'NoOfWives' => $jumlahIsteri, #often-changes
                                    'Under18Child' => $jumlahUnder18, #often-changes
                                    'Over18StudyingChild' => $jumlahOver18, #often-changes
                                    'DiplomaDegreeChile' => $model->DiplomaDegreeChild, #often-changes
                                    'DiplomaDegreeChile_Disable' => $model->DiplomaDegreeChile_Disable, #often-changes
                                    'DisableChild' => $model->DisableChild, #often-changes
                                    'Promotion' => '', //Abaikan
                                    'InstitutionDetail' => [ //futher discussion #GRP #often-changes
                                        'InstitutionDetails' => [
                                            0 => [
                                                'Item' => [
                                                    'Name' => 'InstitutionInfo',
                                                    'Value' => [
                                                        'InstitutionsInfo' => [
                                                            'Institution_SchemeID' => '',
                                                            'Institution_MembershipNo' => '',
                                                            'Institution_ASNBType' => '',
                                                            'Institution_AccountNo' => '',
                                                            'Institution_BankCodes' => '',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $array;
    }

    private function Data($icno)
    {
        $jumlahIsteri = 0;
        $jumlahUnder18 = 0;
        $jumlahOver18 = 0;

        $model = VwIntegrationGrp::findOne(['ICNo' => $icno]);
        $isteri = SubVwIntegrationGrp01::findOne(['ICNO' => $icno]);
        $under18Child = SubVwIntegrationGrp02::findOne(['ICNO' => $icno]);
        $over18Child = SubVwIntegrationGrp03::findOne(['ICNO' => $icno]);

        if ($isteri) {
            $jumlahIsteri = $isteri->JUMLAH_ISTERI;
        }

        if ($under18Child) {
            $under18Child->jumlah;
        }

        if ($over18Child) {
            $over18Child->jumlah;
        }


        $array = [
            'Method' => 'EmployeePost',
            'GateWayName' => 'EmployeeRegister',
            'Attributes' => [
                'Attributes' => [
                    0 => [
                        'Attribute' => [
                            'Name' => 'Employee',
                            'Value' => [
                                'Employee' => [
                                    'Branch' => $model->Branch,
                                    'EmployeeID' => $model->EmployeeID,
                                    'EmployeeName' => $model->EmployeeName,
                                    'DateOfBirth' => $model->DateOfBirth,
                                    'ICNo' => $model->ICNo,
                                    'Status' => $model->STATUS, //tukar dlm view tukar pg english //done
                                    'Email' => $model->Email,
                                    'HPNo' => $model->HPNo,
                                    'HomeNo' => $model->HomeNo,
                                    'Address1' => $model->Address1,
                                    'Address2' => $model->Address2,
                                    'City' => $model->City,
                                    'Country' => 'MY', //tukar dlm view = Ref //Corresponden Address (Malaysia Only)
                                    'PostalCode' => $model->PostalCode,
                                    'State' => $model->State,
                                    'EmployeeClass' => $model->EmployeeClass, //Tukar dlm view (Status Lantikan) //DONE
                                    'Department' => $model->Dept_shortname, //Department = Ref (Shortname) /done
                                    'Position' => $model->Position, //GRED
                                    'WorkStartDate' => $model->WorkStartDate,
                                    'WorkEndDate' => $model->WorkEndDate,
                                    'BeneficiaryAccountNo' => $model->BeneficiaryAccountNo, //(Masih ada kosong)
                                    'BeneficiaryAccountName' => $model->BeneficiaryAccountName, //(Masih ada kosong)
                                    'BeneficiaryBankCode' => $model->BeneficiaryBankCode, //(Masih ada kosong)
                                    'MaritalStatus' => $model->MaritalStatus, // tukar dlm view = ENGLISH //done
                                    'SpouseName' => $model->SpouseName, //Isteri pertama
                                    'SpouseIcNo' => $model->SpouseIcNo, //Isteri pertama
                                    'SpouseTaxNo' => $model->SpouseTaxNo, //Isteri pertama
                                    'SpouseTaxOffice' => $model->SpouseTaxOffice,
                                    'GradeCode' => $model->GradeCode, //GRED
                                    'SalaryGroup' => $model->SalaryGroup, //tukar dlm view Jobgroup KS | PP //done
                                    'PayGroup' => 'BULANAN', //tukar dlm view (SMBU - Pending)
                                    'TaxNo' => $model->TaxNo, //perlu dwujudkan //done
                                    'TaxCategory' => $model->TaxCategory, //perlu dwujudkan //done
                                    'BasicSalary' => $model->BasicSalary, //(SMBU) gaji pokok
                                    'IncrementMonth' => $model->IncrementMonth, //KGT
                                    'PayPattern' => 'STD1', //Pending for discussion (Team Finance)
                                    'ConfirmedDate' => $model->ConfirmedDate, //Tarikh Pengesahan utk staff tetap
                                    'PromotionDate' => $model->PromotionDate, //Kenaikan Pangkat
                                    'NoOfWives' => $jumlahIsteri,
                                    'Under18Child' => $jumlahUnder18,
                                    'Over18StudyingChild' => $jumlahOver18,
                                    'DiplomaDegreeChile' => $model->DiplomaDegreeChild,
                                    'DiplomaDegreeChile_Disable' => $model->DiplomaDegreeChile_Disable,
                                    'DisableChild' => $model->DisableChild,
                                    'Promotion' => '', //Abaikan
                                    'InstitutionDetail' => [ //futher discussion #GRP #often-changes
                                        'InstitutionDetails' => [
                                            0 => [
                                                'Item' => [
                                                    'Name' => 'InstitutionInfo',
                                                    'Value' => [
                                                        'InstitutionsInfo' => [
                                                            'Institution_SchemeID' => '',
                                                            'Institution_MembershipNo' => '',
                                                            'Institution_ASNBType' => '',
                                                            'Institution_AccountNo' => '',
                                                            'Institution_BankCodes' => '',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $array;
    }
}

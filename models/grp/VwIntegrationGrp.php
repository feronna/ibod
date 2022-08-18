<?php

namespace app\models\grp;

use Yii;

/**
 * This is the model class for table "integration.vw_integration_grp".
 *
 * @property string $Branch
 * @property string $EmployeeID
 * @property string $EmployeeName
 * @property string $DateOfBirth
 * @property string $ICNo
 * @property string $Status_
 * @property string $Email
 * @property string $HPNo
 * @property string $HomeNo
 * @property string $Address1
 * @property string $Address2
 * @property string $City
 * @property string $Country
 * @property string $PostalCode
 * @property string $State
 * @property string $EmployeeClass
 * @property string $Department
 * @property string $Position
 * @property string $WorkStartDate
 * @property string $WorkEndDate
 * @property string $BeneficiaryAccountNo
 * @property string $BeneficiaryAccountName
 * @property string $BeneficiaryBankCode
 * @property string $MaritalStatus
 * @property string $SpouseName
 * @property string $SpouseIcNo
 * @property string $SpouseTaxNo
 * @property string $SpouseTaxOffice
 * @property string $GradeCode
 * @property string $SalaryGroup
 * @property string $PayGroup
 * @property string $TaxNo
 * @property string $TaxCategory
 * @property string $BasicSalary
 * @property string $IncrementMonth
 * @property string $PayPattern
 * @property string $ConfirmedDate
 * @property string $PromotionDate
 * @property string $NoOfWives
 * @property string $Under18Child
 * @property string $Over18StudyingChild
 * @property string $DiplomaDegreeChild
 * @property string $DiplomaDegreeChile_Disable
 * @property int $DisableChild
 * @property string $Institution_SchemeID
 * @property string $Institution_MembershipNo
 * @property string $Institution_ASNBType
 * @property string $Institution_AccountNo
 * @property string $Institution_BankCodes
 * @property string $Promotion
 */
class VwIntegrationGrp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'integration.vw_integration_grp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DateOfBirth', 'WorkStartDate', 'WorkEndDate'], 'safe'],
            [['SpouseTaxNo', 'SpouseTaxOffice', 'SalaryGroup', 'PayGroup', 'TaxNo', 'TaxCategory', 'PayPattern', 'PromotionDate', 'Institution_MembershipNo', 'Institution_ASNBType', 'Institution_AccountNo', 'Institution_BankCodes', 'Promotion'], 'string'],
            [['BasicSalary'], 'number'],
            [['DisableChild'], 'integer'],
            [['Branch', 'EmployeeName', 'Status_', 'City', 'Country', 'State', 'EmployeeClass', 'Position', 'MaritalStatus'], 'string', 'max' => 255],
            [['EmployeeID', 'SpouseIcNo'], 'string', 'max' => 15],
            [['ICNo', 'PostalCode'], 'string', 'max' => 12],
            [['Email'], 'string', 'max' => 100],
            [['HPNo', 'HomeNo'], 'string', 'max' => 14],
            [['Address1', 'Address2'], 'string', 'max' => 50],
            [['Department','Dept_shortname'], 'string', 'max' => 300],
            [['BeneficiaryAccountNo', 'BeneficiaryBankCode'], 'string', 'max' => 20],
            [['BeneficiaryAccountName'], 'string', 'max' => 4],
            [['SpouseName'], 'string', 'max' => 80],
            [['GradeCode', 'ConfirmedDate'], 'string', 'max' => 10],
            [['IncrementMonth'], 'string', 'max' => 2],
            [['NoOfWives', 'Under18Child', 'Over18StudyingChild'], 'string', 'max' => 30],
            [['DiplomaDegreeChild', 'DiplomaDegreeChile_Disable', 'Institution_SchemeID'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Branch' => 'Branch',
            'EmployeeID' => 'Employee ID',
            'EmployeeName' => 'Employee Name',
            'DateOfBirth' => 'Date Of Birth',
            'ICNo' => 'Ic No',
            'Status_' => 'Status',
            'Email' => 'Email',
            'HPNo' => 'Hp No',
            'HomeNo' => 'Home No',
            'Address1' => 'Address1',
            'Address2' => 'Address2',
            'City' => 'City',
            'Country' => 'Country',
            'PostalCode' => 'Postal Code',
            'State' => 'State',
            'EmployeeClass' => 'Employee Class',
            'Department' => 'Department',
            'Position' => 'Position',
            'WorkStartDate' => 'Work Start Date',
            'WorkEndDate' => 'Work End Date',
            'BeneficiaryAccountNo' => 'Beneficiary Account No',
            'BeneficiaryAccountName' => 'Beneficiary Account Name',
            'BeneficiaryBankCode' => 'Beneficiary Bank Code',
            'MaritalStatus' => 'Marital Status',
            'SpouseName' => 'Spouse Name',
            'SpouseIcNo' => 'Spouse Ic No',
            'SpouseTaxNo' => 'Spouse Tax No',
            'SpouseTaxOffice' => 'Spouse Tax Office',
            'GradeCode' => 'Grade Code',
            'SalaryGroup' => 'Salary Group',
            'PayGroup' => 'Pay Group',
            'TaxNo' => 'Tax No',
            'TaxCategory' => 'Tax Category',
            'BasicSalary' => 'Basic Salary',
            'IncrementMonth' => 'Increment Month',
            'PayPattern' => 'Pay Pattern',
            'ConfirmedDate' => 'Confirmed Date',
            'PromotionDate' => 'Promotion Date',
            'NoOfWives' => 'No Of Wives',
            'Under18Child' => 'Under18 Child',
            'Over18StudyingChild' => 'Over18 Studying Child',
            'DiplomaDegreeChild' => 'Diploma Degree Child',
            'DiplomaDegreeChile_Disable' => 'Diploma Degree Chile  Disable',
            'DisableChild' => 'Disable Child',
            'Institution_SchemeID' => 'Institution  Scheme ID',
            'Institution_MembershipNo' => 'Institution  Membership No',
            'Institution_ASNBType' => 'Institution  Asnb Type',
            'Institution_AccountNo' => 'Institution  Account No',
            'Institution_BankCodes' => 'Institution  Bank Codes',
            'Promotion' => 'Promotion',
        ];
    }
}

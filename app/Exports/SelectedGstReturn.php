<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\expertform;

class SelectedGstReturn implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $details = DB::table('fpo_details')
            ->where(function ($query) {
                $query->where('data', 'LIKE', '%"first_form"%')
                    ->orWhere('data', 'LIKE', '%"expert_id"%');
            })
            ->where('data', 'LIKE', '%"selectedGstReturn"%')
            ->get();

            $detailsWithForms = $details->map(function ($detail) {
                $data = json_decode($detail->data, true);
                $firstForm = $data['first_form'] ?? null;
                $expertId = $data['expert_id'] ?? null;
                $expertForm = ExpertForm::find($expertId);
            
                if ($expertForm) {
                    $expertFormData = json_decode($expertForm->data, true);
            
                    // Combine both first_form and expert_id data
                    $combinedData = array_merge((array)$firstForm, (array)$expertFormData);
            
                }

                // Fallback logic
                $selectedExpert = $firstForm['selectedExpert'] ?? $expertFormData['selectedExpert'] ?? null;
                $inspectionDate = $firstForm['inspectionDate'] ?? $expertFormData['inspectionDate'] ?? null;
                $selectedIA = $firstForm['selectedIA'] ?? $expertFormData['selectedIA'] ?? null;
                $selectedCbbo = $firstForm['selectedCbbo'] ?? $expertFormData['selectedCbbo'] ?? null;
                $selectedState = $firstForm['selectedState'] ?? $expertFormData['selectedState'] ?? null;
                $selectedDistrict = $firstForm['selectedDistrict'] ?? $expertFormData['selectedDistrict'] ?? null;
                $selectedBlock = $firstForm['selectedBlock'] ?? $expertFormData['selectedBlock'] ?? null;
                $selectedFPO = $firstForm['selectedFPO'] ?? $expertFormData['selectedFPO'] ?? null;
                $selectedFPOAddress = $firstForm['selectedFpoAddress'] ?? $expertFormData['selectedFpoAddress'] ?? null;
                $addressInMIS = $firstForm['addressInMis'] ?? $expertFormData['addressInMis'] ?? null;
                $correctAddress = $firstForm['correctAddress'] ?? $expertFormData['correctAddress'] ?? null;
                $numberOfShareholders = $firstForm['numberShareholders'] ?? $expertFormData['numberShareholders'] ?? null;
                $shareholdersCorrectInMIS = $firstForm['shareholderCorrectInMis'] ?? $expertFormData['shareholderCorrectInMis'] ?? null;
                $ceoName = $firstForm['ceoName'] ?? $expertFormData['ceoName'] ?? null;
                $isCeoCorrect = $firstForm['isCeoCorrect'] ?? $expertFormData['isCeoCorrect'] ?? null;
                $offerLetterCeo = $firstForm['offerLetterCeo'] ?? $expertFormData['offerLetterCeo'] ?? null;
                $accountantName = $firstForm['accountantName'] ?? $expertFormData['accountantName'] ?? null;
                $isCorrectAccountant = $firstForm['isCorrectAccountant'] ?? $expertFormData['isCorrectAccountant'] ?? null;
                $accountantAppointed = $firstForm['accountantAppointed'] ?? $expertFormData['accountantAppointed'] ?? null;
                $offerLetterAccount = $firstForm['offerLetterAccount'] ?? $expertFormData['offerLetterAccount'] ?? null;

                return  [
                    'selectedExpert' => $selectedExpert,
                    'inspectionDate' => $inspectionDate,
                    'selectedIA' => $selectedIA,
                    'selectedCbbo' => $selectedCbbo,
                    'selectedState' => $selectedState,
                    'selectedDistrict' => $selectedDistrict,
                    'selectedBlock' => $selectedBlock,
                    'selectedFPO' => $selectedFPO,
                    'selectedFPOAddress' => $selectedFPOAddress,
                    'addressInMIS' => $addressInMIS,
                    'correctAddress' => $correctAddress,
                    'numberOfShareholders' => $numberOfShareholders,
                    'shareholdersCorrectInMIS' => $shareholdersCorrectInMIS,
                    'ceoName' => $ceoName,
                    'isCeoCorrect' => $isCeoCorrect,
                    'offerLetterCeo' => $offerLetterCeo,
                    'accountantName' => $accountantName,
                    'isCorrectAccountant' => $isCorrectAccountant,
                    'accountantAppointed' => $accountantAppointed,
                    'offerLetterAccount' => $offerLetterAccount,

                    'selectedGstReturn' => $data['selectedGstReturn'] ?? null,
                    'rmGstReturn' => $data['rmGstReturn'] ?? null,
                    'slctQtrBrdMt' => $data['slctQtrBrdMt'] ?? null,
                    'rmQtrBrdMt' => $data['rmQtrBrdMt'] ?? null,
                    'slctAuditFinSt' => $data['slctAuditFinSt'] ?? null,
                    'rmAuditFinSt' => $data['rmAuditFinSt'] ?? null,
                    'slctAGMmeet' => $data['slctAGMmeet'] ?? null,
                    'hasPostHarvest' => $data['hasPostHarvest'] ?? null,
                    'rmAGMmeet' => $data['rmAGMmeet'] ?? null,
                    'haveCreditCard' => $data['haveCreditCard'] ?? null,
                    'isCreditCardCgf' => $data['isCreditCardCgf'] ?? null,
                    'isAIFChecked' => $data['isAIFChecked'] ?? null,
                    'isPMFMEChecked' => $data['isPMFMEChecked'] ?? null,
                    'isPMEGPChecked' => $data['isPMEGPChecked'] ?? null,
                    'isOtherChecked' => $data['isOtherChecked'] ?? null,
                    'loanAmount' => $data['loanAmount'] ?? null,
                    'numberOfVisits' => $data['numberOfVisits'] ?? null,
                    'visitActionPlan' => $data['visitActionPlan'] ?? null,
                    'otherSchemes' => $data['otherSchemes'] ?? null,
                    'otherERPs' => $data['otherERPs'] ?? null,
                    'legalActivities' => $data['legalActivities'] ?? null,
                    'challenges' => $data['challenges'] ?? null,
                    'suggestions' => $data['suggestions'] ?? null,
                    'address' => $data['address'] ?? null,
                    'imageFilePath' => $data['imageFilePath'] ?? null,
                    'location' => $data['location'] ?? null,
                    'hasConnectivity' => $this->flattenArray($data['hasConnectivity'] ?? null),
                    'profileUpdatedOnMIS' => $this->flattenArray($data['profileUpdatedOnMIS'] ?? null),
                ];
            });
    
            return $detailsWithForms;
        }


    public function headings(): array
    {
        return [
            'expert_id',
            'Selected Expert',
            'Inspection Date',
            'Selected IA',
            'Selected CBBO',
            'Selected State',
            'Selected District',
            'Selected Block',
            'Selected FPO',
            'Selected FPO Address',
            'Address in MIS',
            'Correct Address',
            'Number of Shareholders',
            'Shareholders Correct in MIS',
            'Correct Shareholders',
            'CEO Name',
            'Is CEO Correct',
            'CEO Appointed',
            'Correct CEO',
            'Offer Letter CEO',
            'Accountant Name',
            'Is Correct Accountant',
            'Accountant Appointed',
            'Correct Accountant',
            'Offer Letter Accountant',
            'Selected GST Return',
            'RM GST Return',
            'Selected Quarter Board Meeting',
            'RM Quarter Board Meeting',
            'Selected Audit Financial Statement',
            'RM Audit Financial Statement',
            'Selected AGM Meeting',
            'Has Post-Harvest Activities',
            'RM AGM Meeting',
            'Have Credit Card',
            'Is Credit Card CGF',
            'Is AIF Checked',
            'Is PMFME Checked',
            'Is PMEGP Checked',
            'Is Other Checked',
            'Loan Amount',
            'Number of Visits',
            'Visit Action Plan',
            'Other Schemes',
            'Other ERPs',
            'Legal Activities',
            'Challenges',
            'Suggestions',
            'Address',
            'Image File Path',
            'Location',
            'Has Connectivity', // Adding heading for hasConnectivity
            'Profile Updated On MIS', // Adding heading for profileUpdatedOnMIS
        ];
    }

    private function flattenArray($array)
    {
        if (is_array($array)) {
            return implode(', ', array_filter($array, function ($item) {
                return !empty($item);
            }));
        }
        return $array;
    }



    
}

<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use App\Models\details;
use App\Models\expertform;

class NewSelectedGstReturn implements FromCollection, WithHeadings
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
            ->distinct()
            ->get();

        $detailsWithForms = [];

        foreach ($details as $detail) {
            $data = json_decode($detail->data, true);
            $firstForm = $data['first_form'] ?? null;
            $expertId = $data['expert_id'] ?? null;

            // Using the ExpertForm model to fetch data
            $expertForm = ExpertForm::find($expertId);

            if ($expertForm) {
                $expertFormId = $expertForm->id;
                $expertFormData = json_decode($expertForm->data, true) ?? [];
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

            $otherSchemes = isset($data['otherSchemes']) ? implode(', ', (array) $data['otherSchemes']) : null;
            $otherERPs = isset($data['otherERPs']) ? implode(', ', (array) $data['otherERPs']) : null;
            $legalActivities = isset($data['legalActivities']) ? implode(', ', (array) $data['legalActivities']) : null;
            $challenges = isset($data['challenges']) ? implode(', ', (array) $data['challenges']) : null;
            $suggestions = isset($data['suggestions']) ? implode(', ', (array) $data['suggestions']) : null;
            // Returning an array with all necessary fields
            $detailsWithForms[] = [
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
                'slctQtrBrdMt' => $data['slctQtrBrdMt'] ?? null,
                'rmQtrBrdMt' => $data['rmQtrBrdMt'] ?? null,
                'slctAuditFinSt' => $data['slctAuditFinSt'] ?? null,
                'haveCreditCard' => $data['haveCreditCard'] ?? null,
                'isCreditCardCgf' => $data['isCreditCardCgf'] ?? null,
                'isAIFChecked' => $data['isAIFChecked'] ?? null,
                'isPMFMEChecked' => $data['isPMFMEChecked'] ?? null,
                'isPMEGPChecked' => $data['isPMEGPChecked'] ?? null,
                'isOtherChecked' => $data['isOtherChecked'] ?? null,
                'loanAmount' => $data['loanAmount'] ?? null,
                'numberOfVisits' => $data['numberOfVisits'] ?? null,
                'visitActionPlan' => $data['visitActionPlan'] ?? null,
                'otherSchemes' => $otherSchemes,
                'otherERPs' => $otherERPs,
                'legalActivities' => $legalActivities,
                'challenges' => $challenges,
                'suggestions' => $suggestions,
                'address' => $data['address'] ?? null,
                'location' => $data['location'] ?? null,

            ];
        }

        // return $detailsWithForms;
        return collect($detailsWithForms);
    }



    public function headings(): array
    {
        return [
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
            'CEO Name',
            'Is CEO Correct',
            'Offer Letter CEO',
            'Accountant Name',
            'Is Correct Accountant',
            'Accountant Appointed',
            'Offer Letter Account',

            'Selected GST Return',
            'Selected Qtr Brd Mt',
            'RM Qtr Brd Mt',
            'Selected Audit Fin St',
            'Have Credit Card',
            'Is Credit Card Cgf',
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
            'Location',


        ];
    }
}

<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use App\Models\details;
use App\Models\expertform;

class AwarenessProgram implements FromCollection, WithHeadings
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
            ->where('data', 'LIKE', '%"awarenessProgram"%')
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
                'awarenessProgram' => $data['awarenessProgram'] ?? null,
                'farmerShareIncrease' => $data['farmerShareIncrease'] ?? null,
                'certificatesShareholder' => $data['certificatesShareholder'] ?? null,
                'contributionShareholder' => $data['contributionShareholder'] ?? null,
                'numberEventConduct' => $data['numberEventConduct'] ?? null,
                'visitActionPlan' => $data['platformAvailability'] ?? null,
                'numberOfVisits' => $data['numberOfVisits'] ?? null,
                'activity_1' => $data['activity_1'] ?? null,
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

            'awarenessProgram',
            'farmerShareIncrease',
            'certificatesShareholder',
            'contributionShareholder',
            'numberEventConduct',
            'visitActionPlan',
            'numberOfVisits',
            'activity_1',
            'challenges',
            'suggestions',
            'address',
            'location',

        ];
    }
}

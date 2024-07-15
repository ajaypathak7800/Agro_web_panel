<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\details;
use App\Models\expertform;

class NewhasConnectivity implements FromCollection, WithHeadings
{
    public function collection()
    {
        $details = DB::table('fpo_details')
            ->where(function ($query) {
                $query->where('data', 'LIKE', '%"first_form"%')
                    ->orWhere('data', 'LIKE', '%"expert_id"%');
            })
            ->where('data', 'LIKE', '%"hasConnectivity"%')
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

            // Returning an array with all necessary fields from first_form and expert_id
            $detailsWithForms[] = [
                // Fields from first_form
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

                // hasConnectivity field
                'hasConnectivity' => $this->flattenArray($data['hasConnectivity'] ?? null),
                'profileUpdatedOnMIS' => $this->flattenArray($data['profileUpdatedOnMIS'] ?? null),
                'challengesFacedOnMIS' => $this->flattenArray($data['challengesFacedOnMIS'] ?? null),
                'trainingsProvidedByCBBO' => $this->flattenArray($data['trainingsProvidedByCBBO'] ?? null),
                'activitiesPerformed' => $this->flattenArray($data['activitiesPerformed'] ?? null),
                'hasITIssue' => $this->flattenArray($data['hasITIssue'] ?? null),
                'trainingsConductedByExpert' => $this->flattenArray($data['trainingsConductedByExpert'] ?? null),
                'trainingActionPlan' => $this->flattenArray($data['trainingActionPlan'] ?? null),
                'numberOfVisits' => $this->flattenArray($data['numberOfVisits'] ?? null),
                'visitActionPlan' => $this->flattenArray($data['visitActionPlan'] ?? null),
                'challenges' => $this->flattenArray($data['challenges'] ?? null),
                'suggestions' => $this->flattenArray($data['suggestions'] ?? null),
                'location' => $this->flattenArray($data['location'] ?? null),
                'address' => $this->flattenArray($data['address'] ?? null),
            ];
        }

        // return $detailsWithForms;
        return collect($detailsWithForms);
    }

    private function flattenArray($value)
    {
        if (is_array($value)) {
            return implode(', ', array_filter($value, function ($item) {
                return !is_null($item) && $item !== '';
            }));
        }
        return $value;
    }

    public function headings(): array
    {
        return [
            // Headings for first_form fields
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
            // Heading for hasConnectivity
            'Has Connectivity',
            // Additional headings
            'Profile Updated On MIS',
            'Challenges Faced On MIS',
            'Trainings Provided By CBBO',
            'Activities Performed',
            'Has IT Issue',
            'Trainings Conducted By Expert',
            'Training Action Plan',
            'Number of Visits',
            'Visit Action Plan',
            'Challenges',
            'Suggestions',
            'Location',
            'Address',
        ];
    }
}

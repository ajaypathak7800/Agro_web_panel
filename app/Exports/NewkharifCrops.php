<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use App\Models\details;
use App\Models\expertform;

class NewkharifCrops implements FromCollection, WithHeadings
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
            ->where('data', 'LIKE', '%"kharifCrops"%')
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
            // Converting arrays to strings
            $kharifCrops = isset($data['kharifCrops']) ? implode(', ', (array) $data['kharifCrops']) : null;
            $kharifFarmers = isset($data['kharifFarmers']) ? implode(', ', (array) $data['kharifFarmers']) : null;
            $rabiCrops = isset($data['rabiCrops']) ? implode(', ', (array) $data['rabiCrops']) : null;
            $rabiFarmers = isset($data['rabiFarmers']) ? implode(', ', (array) $data['rabiFarmers']) : null;
            $zaidCrops = isset($data['zaidCrops']) ? implode(', ', (array) $data['zaidCrops']) : null;
            $zaidFarmers = isset($data['zaidFarmers']) ? implode(', ', (array) $data['zaidFarmers']) : null;
            $qualitySeedsSource = isset($data['qualitySeedsSource']) ? implode(', ', (array) $data['qualitySeedsSource']) : null;
            $fertilisersSource = isset($data['fertilisersSource']) ? implode(', ', (array) $data['fertilisersSource']) : null;
            $cropHusbandryActivities = isset($data['cropHusbandryActivities']) ? implode(', ', (array) $data['cropHusbandryActivities']) : null;
            $suggestions = isset($data['suggestions']) ? implode(', ', (array) $data['suggestions']) : null;
            $challenges = isset($data['challenges']) ? implode(', ', (array) $data['challenges']) : null;

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

                'kharifCrops' => $kharifCrops,
                'kharifFarmers' => $kharifFarmers,
                'rabiCrops' => $rabiCrops,
                'rabiFarmers' => $rabiFarmers,
                'zaidCrops' => $zaidCrops,
                'zaidFarmers' => $zaidFarmers,
                'hasQualitySeeds' => $data['hasQualitySeeds'] ?? null,
                // 'qualitySeedsSource' => $data['qualitySeedsSource'] ?? null,
                'qualitySeedsSource' => $qualitySeedsSource,
                'hasFertilisers' => $data['hasFertilisers'] ?? null,
                'fertilisersSource' => $fertilisersSource,
                'hasPostHarvest' => $data['hasPostHarvest'] ?? null,
                // 'postHarvestActivities' => $data['postHarvestActivities'] ?? null,
                'isSortingChecked' => isset($data['postHarvestActivities']['isSortingChecked']) ? ($data['postHarvestActivities']['isSortingChecked'] ? 'true' : 'false') : 'false',
                'isGradingChecked' => isset($data['postHarvestActivities']['isGradingChecked']) ? ($data['postHarvestActivities']['isGradingChecked'] ? 'true' : 'false') : 'false',
                'isProcessingChecked' => isset($data['postHarvestActivities']['isProcessingChecked']) ? ($data['postHarvestActivities']['isProcessingChecked'] ? 'true' : 'false') : 'false',
                'isStorageChecked' => isset($data['postHarvestActivities']['isStorageChecked']) ? ($data['postHarvestActivities']['isStorageChecked'] ? 'true' : 'false') : 'false',
                'isTransportationChecked' => isset($data['postHarvestActivities']['isTransportationChecked']) ? ($data['postHarvestActivities']['isTransportationChecked'] ? 'true' : 'false') : 'false',
                'isOthersChecked' => isset($data['postHarvestActivities']['isOthersChecked']) ? ($data['postHarvestActivities']['isOthersChecked'] ? 'true' : 'false') : 'false',

                'otherHarvestInfra' => $data['otherHarvestInfra'] ?? null,
                'hasIrrigation' => $data['hasIrrigation'] ?? 'null',
                'isSprinklerChecked' => isset($data['irrigationDetails']['isSprinklerChecked']) ? ($data['irrigationDetails']['isSprinklerChecked'] ? 'true' : 'false') : 'false',
                'isDripChecked' => isset($data['irrigationDetails']['isDripChecked']) ? ($data['irrigationDetails']['isDripChecked'] ? 'true' : 'false') : 'false',
                'isFurrowChecked' => isset($data['irrigationDetails']['isFurrowChecked']) ? ($data['irrigationDetails']['isFurrowChecked'] ? 'true' : 'false') : 'false',
                'isOtherIrrigationChecked' => isset($data['irrigationDetails']['isOtherIrrigationChecked']) ? ($data['irrigationDetails']['isOtherIrrigationChecked'] ? 'true' : 'false') : 'false',
                'otherIrrigationType' => $data['otherIrrigationType'] ?? null,
                'cropHusbandryActivities' => $cropHusbandryActivities,
                'numberOfVisits' => $data['numberOfVisits'] ?? null,
                'visitActionPlan' => $data['visitActionPlan'] ?? null,
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

            "kharifCrops",
            "kharifFarmers",
            "rabiCrops",
            "rabiFarmers",
            "zaidCrops",
            "zaidFarmers",
            "hasQualitySeeds",
            "qualitySeedsSource",
            "hasFertilisers",
            "fertilisersSource",
            "hasPostHarvest",
            // "postHarvestActivities",
            "isSortingChecked",
            "isGradingChecked",
            "isProcessingChecked",
            "isStorageChecked",
            "isTransportationChecked",
            "isOthersChecked",
            "otherHarvestInfra",
            "hasIrrigation",
            "isSprinklerChecked",
            "isDripChecked",
            "isFurrowChecked",
            "isOtherIrrigationChecked",
            "otherIrrigationType",
            "cropHusbandryActivities",
            "numberOfVisits",
            "visitActionPlan",
            "challenges",
            "suggestions",
            "address",
            "location",

        ];
    }
}

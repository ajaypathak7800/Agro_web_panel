<?php

namespace App\Exports;

use App\Models\details;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use App\Models\expertform;

class kharifCrops implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $details = DB::table('fpo_details')
            ->where('data', 'LIKE', '%"expert_id"%')
            ->where('data', 'LIKE', '%"kharifCrops"%')
            ->distinct()
            ->get();

        $dataArray = [];

        foreach ($details as $detail) {
            $data = json_decode($detail->data, true);
            $expertId = $data['expert_id'] ?? null;
            $expertForm = details::find($expertId);

            if ($expertForm) {
                $jsonColumnData = json_decode($expertForm->data, true);

                // Check for empty values and set them to null
                foreach ($jsonColumnData as $key => $value) {
                    if (empty($value)) {
                        $jsonColumnData[$key] = null;
                    }
                }

                
                $dataArray[] = [
                    'expert_id' => $expertId,
                    'selectedExpert' => $jsonColumnData['selectedExpert'] ?? 'null',
                    'inspectionDate' => $jsonColumnData['inspectionDate'] ?? 'null',
                    'selectedIA' => $jsonColumnData['selectedIA'] ?? 'null',
                    'selectedCbbo' => $jsonColumnData['selectedCbbo'] ?? 'null',
                    'selectedState' => $jsonColumnData['selectedState'] ?? 'null',
                    'selectedDistrict' => $jsonColumnData['selectedDistrict'] ?? 'null',
                    'selectedBlock' => $jsonColumnData['selectedBlock'] ?? 'null',
                    'selectedFPO' => $jsonColumnData['selectedFPO'] ?? 'null',
                    'selectedFPOAddress' => $jsonColumnData['selectedFpoAddress'] ?? 'null',
                    'addressInMIS' => $jsonColumnData['addressInMis'] ?? 'null',
                    'correctAddress' => $jsonColumnData['correctAddress'] ?? 'null',
                    'numberOfShareholders' => $jsonColumnData['numberShareholders'] ?? 'null',
                    'shareholdersCorrectInMIS' => $jsonColumnData['shareholderCorrectInMis'] ?? 'null',
                    'correctShareholders' => $jsonColumnData['correctShareholders'] ?? 'null',
                    'ceoName' => $jsonColumnData['ceoName'] ?? 'null',
                    'isCeoCorrect' => $jsonColumnData['isCeoCorrect'] ?? 'null',
                    'ceoAppointed' => $jsonColumnData['ceoAppointed'] ?? 'null',
                    'correctCeo' => $jsonColumnData['correctCeo'] ?? 'null',
                    'offerLetterCeo' => $jsonColumnData['offerLetterCeo'] ?? 'null',
                    'accountantName' => $jsonColumnData['accountantName'] ?? 'null',
                    'isCorrectAccountant' => $jsonColumnData['isCorrectAccountant'] ?? 'null',
                    'accountantAppointed' => $jsonColumnData['accountantAppointed'] ?? 'null',
                    'correctAccountant' => $jsonColumnData['correctAccountant'] ?? 'null',
                    'offerLetterAccount' => $jsonColumnData['offerLetterAccount'] ?? 'null',

                    'kharifCrops' => $data['kharifCrops'] ?? 'null',
                    'rabiCrops' => $data['rabiCrops'] ?? 'null',
                    'zaidCrops' => $data['zaidCrops'] ?? 'null',
                    'hasQualitySeeds' => $data['hasQualitySeeds'] ?? 'null',
                    'qualitySeedsSource' => $data['qualitySeedsSource'] ?? 'null',
                    'hasFertilisers' => $data['platformAvailability']['gem'] ?? 'null',
                    'fertilisersSource' => $data['platformAvailability']['enam'] ?? 'null',
                    'hasPostHarvest' => $data['platformAvailability']['ondc'] ?? 'null',
                    'postHarvestActivities' => $data['postHarvestActivities'] ?? 'null',
                    'hasIrrigation' => $data['hasIrrigation'] ?? 'null',
                    'irrigationDetails' => $data['irrigationDetails'] ?? 'null',
                    'cropHusbandryActivities' => $data['cropHusbandryActivities'] ?? 'null',
                    'numberOfVisits' => $data['numberOfVisits'] ?? 'null',
                    'visitActionPlan' => $data['visitActionPlan'] ?? 'null',
                    'challenges' => $data['challenges'] ?? 'null',
                    'suggestions' => $data['suggestions'] ?? 'null',
                    'address' => $data['address'] ?? 'null',
                    'imageFilePath' => $data['imageFilePath'] ?? 'null',
                    'pictureTimestamp' => $data['pictureTimestamp'] ?? 'null',

                ];
            }
        }

        return collect($dataArray);
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
            'Offer Letter Account',
            'Kharif Crops',
            'Rabi Crops',
            'Zaid Crops',
            'Has Quality Seeds',
            'Quality Seeds Source',
            'Has Fertilisers',
            'Fertilisers Source',
            'Has Post-Harvest Activities',
            'Post-Harvest Activities',
            'Has Irrigation',
            'Irrigation Details',
            'Crop Husbandry Activities',
            'Number of Visits',
            'Visit Action Plan',
            'Challenges',
            'Suggestions',
            'Address',
            'Image File Path',
            'Picture Timestamp'


        ];
    }
}

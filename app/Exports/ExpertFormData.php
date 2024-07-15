<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use App\Models\expertform;

class ExpertFormData implements FromCollection, WithHeadings
{

    public function collection()
    {
        $details = DB::table('fpo_details')
            ->where('data', 'LIKE', '%"expert_id"%')
            ->where('data', 'LIKE', '%"expertFormData"%')
            ->distinct()
            ->get();
    
        $dataArray = [];

        foreach ($details as $detail) {
            $data = json_decode($detail->data, true);
            $expertId = $data['expert_id'] ?? null;
            $expertForm = expertform::find($expertId);

            if ($expertForm) {
                $jsonColumnData = json_decode($expertForm->data, true);

                $dataArray[] = [
                    'expert_id' => $expertId,
                    'selectedExpert' => $jsonColumnData['selectedExpert'] ?? null,
                    'inspectionDate' => $jsonColumnData['inspectionDate'] ?? null,
                    'selectedIA' => $jsonColumnData['selectedIA'] ?? null,
                    'selectedCbbo' => $jsonColumnData['selectedCbbo'] ?? null,
                    'selectedState' => $jsonColumnData['selectedState'] ?? null,
                    'selectedDistrict' => $jsonColumnData['selectedDistrict'] ?? null,
                    'selectedBlock' => $jsonColumnData['selectedBlock'] ?? null,
                    'selectedFPO' => $jsonColumnData['selectedFPO'] ?? null,
                    'selectedFPOAddress' => $jsonColumnData['selectedFpoAddress'] ?? null,
                    'addressInMIS' => $jsonColumnData['addressInMis'] ?? null,
                    'correctAddress' => $jsonColumnData['correctAddress'] ?? null,
                    'numberOfShareholders' => $jsonColumnData['numberShareholders'] ?? null,
                    'shareholdersCorrectInMIS' => $jsonColumnData['shareholderCorrectInMis'] ?? null,
                    'correctShareholders' => $jsonColumnData['correctShareholders'] ?? null,
                    'ceoName' => $jsonColumnData['ceoName'] ?? null,
                    'isCeoCorrect' => $jsonColumnData['isCeoCorrect'] ?? null,
                    'ceoAppointed' => $jsonColumnData['ceoAppointed'] ?? null,
                    'correctCeo' => $jsonColumnData['correctCeo'] ?? null,
                    'offerLetterCeo' => $jsonColumnData['offerLetterCeo'] ?? null,
                    'accountantName' => $jsonColumnData['accountantName'] ?? null,
                    'isCorrectAccountant' => $jsonColumnData['isCorrectAccountant'] ?? null,
                    'accountantAppointed' => $jsonColumnData['accountantAppointed'] ?? null,
                    'correctAccountant' => $jsonColumnData['correctAccountant'] ?? null,
                    'offerLetterAccount' => $jsonColumnData['offerLetterAccount'] ?? null,
                    'awarenessProgram' => $data['awarenessProgram'] ?? null,
                    'farmerShareIncrease' => $data['farmerShareIncrease'] ?? null,
                    'certificatesShareholder' => $data['certificatesShareholder'] ?? null,
                    'numberEventConduct' => $data['numberEventConduct'] ?? null,
                    'visitActionPlan' => $data['visitActionPlan'] ?? null,
                    'numberOfVisits' => $data['numberOfVisits'] ?? null,
                    'activity_1' => $data['activity_1'] ?? null,
                    'activity_2' => $data['activity_2'] ?? null,
                    'challenges' => $data['challenges'] ?? null,
                    'suggestions' => $data['suggestions'] ?? null,
                    'imageFilePath' => $data['imageFilePath'] ?? null,
                    'location' => $data['location'] ?? null,
                    'address' => $data['address'] ?? null,
                    'pictureTimestamp' => $data['pictureTimestamp'] ?? null,






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
            'Awareness Program',
            'Farmer Share Increase',
            'Certificates Shareholder',
            'Number of Events Conducted',
            'Visit Action Plan',
            'Number of Visits',
            'Activity 1',
            'Activity 2',
            'Challenges',
            'Suggestions',
            'Image File Path',
            'Location',
            'Address',
            'Picture Timestamp'

        ];
    }
    
}

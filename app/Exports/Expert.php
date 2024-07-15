<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\expertform;
use App\Models\details;

class Expert implements FromCollection, WithHeadings
{
    public function collection()
    {
        $details = DB::table('fpo_details')
            ->where('data', 'LIKE', '%"first_form"%')
            ->where('data', 'LIKE', '%"hasConnectivity"%')
            ->distinct()
            ->get();

        // Mapping each detail and decoding JSON data
        $detailsWithForms = $details->map(function ($detail) {
            $data = json_decode($detail->data, true);
            $firstForm = $data['first_form'] ?? [];

            // Returning an array with all necessary fields
            return [
                'first_form' => $firstForm['first_form'] ?? null,
                'selectedExpert' => $firstForm['selectedExpert'] ?? null,
                'inspectionDate' => $firstForm['inspectionDate'] ?? null,
                'selectedIA' => $firstForm['selectedIA'] ?? null,
                'selectedCbbo' => $firstForm['selectedCbbo'] ?? null,
                'selectedState' => $firstForm['selectedState'] ?? null,
                'selectedDistrict' => $firstForm['selectedDistrict'] ?? null,
                'selectedBlock' => $firstForm['selectedBlock'] ?? null,
                'selectedFPO' => $firstForm['selectedFPO'] ?? null,
                'selectedFPOAddress' => $firstForm['selectedFpoAddress'] ?? null,
                'addressInMIS' => $firstForm['addressInMis'] ?? null,
                'correctAddress' => $firstForm['correctAddress'] ?? null,
                'numberOfShareholders' => $firstForm['numberShareholders'] ?? null,
                'shareholdersCorrectInMIS' => $firstForm['shareholderCorrectInMis'] ?? null,
                'ceoName' => $firstForm['ceoName'] ?? null,
                'isCeoCorrect' => $firstForm['isCeoCorrect'] ?? null,
                'offerLetterCeo' => $firstForm['offerLetterCeo'] ?? null,
                'accountantName' => $firstForm['accountantName'] ?? null,
                'isCorrectAccountant' => $firstForm['isCorrectAccountant'] ?? null,
                'accountantAppointed' => $firstForm['accountantAppointed'] ?? null,
                'offerLetterAccount' => $firstForm['offerLetterAccount'] ?? null,
                'hasConnectivity' => $data['hasConnectivity'] ?? null,
                'profileUpdatedOnMIS' => $data['profileUpdatedOnMIS'] ?? null,
                'challengesFacedOnMIS' => $data['challengesFacedOnMIS'] ?? null,
                'trainingsProvidedByCBBO' => $data['trainingsProvidedByCBBO'] ?? null,
                'activitiesPerformed' => $data['activitiesPerformed'] ?? null,
                'hasITIssue' => $data['hasITIssue'] ?? null,
                'trainingsConductedByExpert' => $data['trainingsConductedByExpert'] ?? null,
                'trainingActionPlan' => $data['trainingActionPlan'] ?? null,
                'numberOfVisits' => $data['numberOfVisits'] ?? null,
                'visitActionPlan' => $data['visitActionPlan'] ?? null,
                'challenges' => $data['challenges'] ?? null,
                'suggestions' => $data['suggestions'] ?? null,
                'imageFilePath' => $data['imageFilePath'] ?? null,
                'location' => $data['location'] ?? null,
                'address' => $data['address'] ?? null,
                'pictureTimestamp' => $data['pictureTimestamp'] ?? null,


            ];
        });

        return $detailsWithForms;
    }


    public function headings(): array
    {
        return [
            'First Form',
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
            'Has Connectivity',
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
            'Image File Path',
            'Location',
            'Address',
            'Picture Timestamp',
        ];
    }
}

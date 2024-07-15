<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\ExpertForm;
use Illuminate\Support\Collection;

class FromInputBusiness implements FromCollection, WithHeadings
{
    public function collection()
    {
        $details = DB::table('fpo_details')
            ->where('data', 'LIKE', '%"expert_id"%')
            ->where('data', 'LIKE', '%"fromInputBusiness"%')
            ->distinct()
            ->get();

        $dataArray = [];

        foreach ($details as $detail) {
            $data = json_decode($detail->data, true);
            $expertId = $data['expert_id'] ?? null;
            $expertForm = ExpertForm::find($expertId);

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

                    'fromInputBusiness' => $data['fromInputBusiness'] ?? 'null',
                    'majorActivitiesInputBusiness' => $data['majorActivitiesInputBusiness'] ?? 'null',
                    'fromOutputBusiness' => $data['fromOutputBusiness'] ?? 'null',
                    'majorActivitiesOutputBusiness' => $data['majorActivitiesOutputBusiness'] ?? 'null',
                    'hasMarketAccess' => $data['hasMarketAccess'] ?? 'null',
                    'isLocalChecked' => $data['isLocalChecked'] ?? 'null',
                    'isNationalChecked' => $data['isNationalChecked'] ?? 'null',
                    'isInternationalChecked' => $data['isInternationalChecked'] ?? 'null',
                    'outputHasAccess_rb' => $data['outputHasAccess_rb'] ?? 'null',
                    'hasMarketingChannel' => $data['hasMarketingChannel'] ?? 'null',
                    'isb2bChecked' => $data['isb2bChecked'] ?? 'null',
                    'isb2cChecked' => $data['isb2cChecked'] ?? 'null',
                    'isExportChecked' => $data['isExportChecked'] ?? 'null',
                    'isOthersChecked' => $data['isOthersChecked'] ?? 'null',
                    'platformAvailability' => $data['platformAvailability'] ?? 'null',
                    'onlinePlatforms' => $data['onlinePlatforms'] ?? 'null',
                    'numberLinkages' => $data['numberLinkages'] ?? 'null',
                    'linkageActionPlan' => $data['linkageActionPlan'] ?? 'null',
                    'numberOfMoU' => $data['numberOfMoU'] ?? 'null',
                    'isNationalChecked' => $data['isNationalChecked'] ?? 'null',
                    'institutionalBuyers' => $data['institutionalBuyers'] ?? 'null',
                    'hasMarketingCommunication' => $data['hasMarketingCommunication'] ?? 'null',
                    'marketCommAction' => $data['marketCommAction'] ?? 'null',
                    'hasCollaboration' => $data['hasCollaboration'] ?? 'null',
                    'collaborationTypes' => $data['collaborationTypes'] ?? 'null',
                    'otherCollaborations' => $data['otherCollaborations'] ?? 'null',
                    'collaborationAction' => $data['collaborationAction'] ?? 'null',
                    'isSalesRegisterMaintained' => $data['isSalesRegisterMaintained'] ?? 'null',
                    'salesRegisterComments' => $data['salesRegisterComments'] ?? 'null',
                    'isPurchaseRegisterMaintained' => $data['isPurchaseRegisterMaintained'] ?? 'null',
                    'purchaseRegisterComments' => $data['purchaseRegisterComments'] ?? 'null',
                    'isStockRegisterMaintained' => $data['isStockRegisterMaintained'] ?? 'null',
                    'stockRegisterComments' => $data['stockRegisterComments'] ?? 'null',
                    'numberOfVisits' => $data['numberOfVisits'] ?? 'null',
                    'visitActivities' => $data['visitActivities'] ?? 'null',
                    'challenges' => $data['challenges'] ?? 'null',
                    'suggestions' => $data['suggestions'] ?? 'null',
                    'imageFilePath' => $data['imageFilePath'] ?? 'null',
                    'location' => $data['location'] ?? 'null',
                    'address' => $data['address'] ?? 'null',
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
            'From Input Business',
            'Major Activities in Input Business',
            'From Output Business',
            'Major Activities in Output Business',
            'Has Market Access',
            'Is Local Checked',
            'Is National Checked',
            'Is International Checked',
            'Output Has Access',
            'Has Marketing Channel',
            'Is B2B Checked',
            'Is B2C Checked',
            'Is Export Checked',
            'Is Others Checked',
            'Platform Availability',
            'Online Platforms',
            'Number of Linkages',
            'Linkage Action Plan',
            'Number of MoU',
            'Institutional Buyers',
            'Has Marketing Communication',
            'Marketing Comm Action',
            'Has Collaboration',
            'Collaboration Types',
            'Other Collaborations',
            'Collaboration Action',
            'Is Sales Register Maintained',
            'Sales Register Comments',
            'Is Purchase Register Maintained',
            'Purchase Register Comments',
            'Is Stock Register Maintained',
            'Stock Register Comments',
            'Number of Visits',
            'Visit Activities',
            'Challenges',
            'Suggestions',
            'Image File Path',
            'Location',
            'Address',
            'Picture Timestamp'
        ];
    }
}

<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\details;
use App\Models\expertform;
use Illuminate\Support\Collection;

class NewFromInputBusiness implements FromCollection, WithHeadings
{
    public function collection()
    {
        $details = DB::table('fpo_details')
            ->where(function ($query) {
                $query->where('data', 'LIKE', '%"first_form"%')
                    ->orWhere('data', 'LIKE', '%"expert_id"%');
            })
            ->where('data', 'LIKE', '%"fromInputBusiness"%')
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
            $majorActivitiesInputBusiness = isset($data['majorActivitiesInputBusiness']) ? implode(', ', (array) $data['majorActivitiesInputBusiness']) : null;
            $majorActivitiesOutputBusiness = isset($data['majorActivitiesOutputBusiness']) ? implode(', ', (array) $data['majorActivitiesOutputBusiness']) : null;
            $institutionalBuyers = isset($data['institutionalBuyers']) ? implode(', ', (array) $data['institutionalBuyers']) : null;
            $otherCollaborations = isset($data['otherCollaborations']) ? implode(', ', (array) $data['otherCollaborations']) : null;
            $salesRegisterComments = isset($data['salesRegisterComments']) ? implode(', ', (array) $data['salesRegisterComments']) : null;
            $visitActivities = isset($data['visitActivities']) ? implode(', ', (array) $data['visitActivities']) : null;
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

                'fromInputBusiness' => $data['fromInputBusiness'] ?? null,
                'majorActivitiesInputBusiness' => $majorActivitiesInputBusiness,
                'fromOutputBusiness' => $data['fromOutputBusiness'] ?? null,
                'majorActivitiesOutputBusiness' => $majorActivitiesOutputBusiness,
                'hasMarketAccess' => $data['hasMarketAccess'] ?? null,
                'isLocalChecked' => $data['isLocalChecked'] ?? null,
                'isNationalChecked' => $data['isNationalChecked'] ?? null,
                'isInternationalChecked' => $data['isInternationalChecked'] ?? null,
                'outputHasAccess_rb' => $data['outputHasAccess_rb'] ?? null,
                'hasMarketingChannel' => $data['hasMarketingChannel'] ?? null,
                'isb2bChecked' => $data['isb2bChecked'] ?? null,
                'isb2cChecked' => $data['isb2cChecked'] ?? null,
                'isExportChecked' => $data['isExportChecked'] ?? null,
                'isOthersChecked' => $data['isOthersChecked'] ?? null,
                // 'platformAvailability' => $data['platformAvailability'] ?? null,
                'GeM' => isset($data['platformAvailability']['GeM']) ? $data['platformAvailability']['GeM'] : 0,
                'eNAM' => isset($data['platformAvailability']['eNAM']) ? $data['platformAvailability']['eNAM'] : 0,
                'ONDC' => isset($data['platformAvailability']['ONDC']) ? $data['platformAvailability']['ONDC'] : 0,
                'onlinePlatforms' => $data['onlinePlatforms'] ?? null,
                'numberLinkages' => $data['numberLinkages'] ?? null,
                'linkageActionPlan' => $data['linkageActionPlan'] ?? null,
                'numberOfMoU' => $data['numberOfMoU'] ?? null,
                'institutionalBuyers' => $institutionalBuyers,
                'hasMarketingCommunication' => $data['hasMarketingCommunication'] ?? null,
                'marketCommAction' => $data['marketCommAction'] ?? null,
                'hasCollaboration' => $data['hasCollaboration'] ?? null,
                // 'collaborationTypes' => $data['collaborationTypes'] ?? null,
                'isRetailerChecked' => isset($data['collaborationTypes']['isRetailerChecked']) ? ($data['collaborationTypes']['isRetailerChecked'] ? 'true' : 'false') : 'false',
                'isDistributorChecked' => isset($data['collaborationTypes']['isDistributorChecked']) ? ($data['collaborationTypes']['isDistributorChecked'] ? 'true' : 'false') : 'false',
                'isBuyersChecked' => isset($data['collaborationTypes']['isBuyersChecked']) ? ($data['collaborationTypes']['isBuyersChecked'] ? 'true' : 'false') : 'false',
                'isAggregatorChecked' => isset($data['collaborationTypes']['isAggregatorChecked']) ? ($data['collaborationTypes']['isAggregatorChecked'] ? 'true' : 'false') : 'false',
                'isProcessorChecked' => isset($data['collaborationTypes']['isProcessorChecked']) ? ($data['collaborationTypes']['isProcessorChecked'] ? 'true' : 'false') : 'false',
                'isExporterChecked' => isset($data['collaborationTypes']['isExporterChecked']) ? ($data['collaborationTypes']['isExporterChecked'] ? 'true' : 'false') : 'false',
                'isOtherCollabChecked' => isset($data['collaborationTypes']['isOtherCollabChecked']) ? ($data['collaborationTypes']['isOtherCollabChecked'] ? 'true' : 'false') : 'false',
                'otherCollaborations' => $otherCollaborations,
                'collaborationAction' => $data['collaborationAction'] ?? null,
                'isSalesRegisterMaintained' => $data['isSalesRegisterMaintained'] ?? null,
                'salesRegisterComments' => $salesRegisterComments,
                'isPurchaseRegisterMaintained' => $data['isPurchaseRegisterMaintained'] ?? null,
                'purchaseRegisterComments' => $data['purchaseRegisterComments'] ?? null,
                'isStockRegisterMaintained' => $data['isStockRegisterMaintained'] ?? null,
                'stockRegisterComments' => $data['stockRegisterComments'] ?? null,
                'numberOfVisits' => $data['numberOfVisits'] ?? null,
                'visitActivities' => $visitActivities,
                'challenges' => $challenges,
                'suggestions' => $suggestions,
                'location' => $data['location'] ?? null,
                'address' => $data['address'] ?? null,
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

            'fromInputBusiness',
            'majorActivitiesInputBusiness',
            'fromOutputBusiness',
            'majorActivitiesOutputBusiness',
            'hasMarketAccess',
            'isLocalChecked',
            'isNationalChecked',
            'isInternationalChecked',
            'outputHasAccess_rb',
            'hasMarketingChannel',
            'isb2bChecked',
            'isb2cChecked',
            'isExportChecked',
            'isOthersChecked',
            // 'platformAvailability',
            'GeM',
            'eNAM',
            'ONDC',
            'onlinePlatforms',
            'numberLinkages',
            'linkageActionPlan',
            'numberOfMoU',
            'institutionalBuyers',
            'hasMarketingCommunication',
            'marketCommAction',
            'hasCollaboration',
            // 'collaborationTypes',
            // 'collaborationTypes',
            'isRetailerChecked',
            'isDistributorChecked',
            'isBuyersChecked',
            'isAggregatorChecked',
            'isProcessorChecked',
            'isExporterChecked',
            'isOtherCollabChecked',
            'otherCollaborations',
            'collaborationAction',
            'isSalesRegisterMaintained',
            'salesRegisterComments',
            'isPurchaseRegisterMaintained',
            'purchaseRegisterComments',
            'isStockRegisterMaintained',
            'stockRegisterComments',
            'numberOfVisits',
            'visitActivities',
            'challenges',
            'suggestions',
            'location',
            'address',
        ];
    }
}

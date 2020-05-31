<?php

namespace App\Clients\Clover;

class FieldMapper
{

    const FIELDS = [

        // USABG API                                                                        // AGENCY BLOC
        "first_name"                                            =>                      "firstName",
        "middle_initial"                                    =>                      "middleInitial", 
        "last_name"                                             =>                      "lastName", 
        "individual_id"                                     =>                      "individualID", 
        "birth_date"                                            =>                      "birthDate", 
        "home_phone"                                            =>                      "homePhone", 
        "business_phone"                                    =>                      "businessPhone", 
        "cell_phone"                                            =>                      "cellPhone", 
        "updated_dtm"                                       =>                      "updatedDTM", 
        "detail_url"                                            =>                      "detailURL",
        "medicare_id"                                       =>                      "medicareID",
        "servicing_agent_name"                      =>                      "servicingAgentName",
        "servicing_agent_id"                            =>                      "servicingAgentID",
        "lead_source"                                       =>                      "leadSource",
        "lead_source_other"                             =>                      "leadSourceOther",
        "lead_source_agent_name"                    =>                      "leadSourceAgentName",
        "lead_dtm"                                              =>                      "leadDtm",
        "create_dtm"                                            =>                      "createDTM",
        "update_dtm"                                            =>                      "updateDTM",
        "project_code"                                      =>                      "projectCode",
        "home_phone"                                            =>                      "homePhone",
        "home_phone_ext"                                    =>                      "homePhoneExt",
        "business_phone"                                    =>                      "businessPhone",
        "business_phone_ext"                            =>                      "businessPhoneExt",
        "cell_phone"                                            =>                      "cellPhone",
        "cell_phone_ext"                                    =>                      "cellPhoneExt",
        "group_id"                                              =>                      "groupID",
        // "indivdual_id"                               =>                      "indivdualID",                      // BUG < `AgencyBloc` < invalid spelling of 'indivdualID'
        "smoker_status"                                     =>                      "SmokerStatus",
        "drivers_license_number"                    =>                      "DriversLicenseNumber",
        "deceased_date"                                     =>                      "DeceasedDate",
        "medicare_eff_date_part_a"              =>                      "MedicareEffDatePartA",
        "medicare_eff_date_part_b"              =>                      "MedicareEffDatePartB",
        "external_id"                                       =>                      "ExternalID",
        "custom_fields"                                     =>                      "customFields",
        "family_details"                                    =>                      "Family details", 
        "medical_conditions"                            =>                      "Medical Conditions", 
        "agent_referral_info"                       =>                      "Agent Referral Info: ", 
        "name_other"                                            =>                      "Name-Other", 
        "height_weight"                                     =>                      "Height / Weight", 
        "doctors"                                               =>                      "Doctors", 
        "medications"                                       =>                      "Medications", 
        "income_tax_credit"                             =>                      "Income/Tax Credit", 
        "banking"                                               =>                      "Banking", 
        "occupation"                                            =>                      "Occupation", 
        "agent_id"                                              =>                      "agentID"
    ];


    public static function fromAgencyBloc ($fld) 
    {
        return array_key_exists($fld, ($FIELDS = array_flip(self::FIELDS))) ? $FIELDS[$fld] : $fld;
    }

    public static function toAgencyBloc ($fld) 
    {
        return array_key_exists($fld, self::FIELDS) ? self::FIELDS[$fld] : $fld;
    }
}
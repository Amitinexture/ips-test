<?php

namespace App\Http\Helpers;

use Infusionsoft;
use App\User;
use App\Module;
use App\Tags;

/**
 * Helper class is responsible to get the user details and find out the purchase courses and 
 * calcualte the reminder for upcoming modules. 
 * 
 * The Tags are referred to as Events, and tag event will be triggered from the Infusion Soft and send email to customer.
 * 
 */
class UserReminderHelper {

    private $infusionsoft;
    private $userEmail = '';
    private $userModel;

    public function __construct($userEmail) {
        $this->userEmail = $userEmail;
        $this->infusionsoft = new InfusionsoftHelper();

        $this->userModel = new User();
    }

    /**
     * The function will check the user purchased course and perform reminder validation and setup correct reminder tags.
     * 
     * @Step 1: Check the supplied user in database, if user found that goes to Infusion API and fetch the details about the user.
     * 
     * @Step 2: Now cross check if user did any purchase than split the string in array for further process
     * 
     * @Step 3: This step is devided into small different validation part..
     *          - Get All Completed module count. if contact have completed any modules.
     *          - Then find the last completed module count and set reminder for next uncompleted module.
     *          - If contact did not started any module yet, than add the purchase module's 1st module to reminder tag.
     *          - After checking everything if finds that contact finished all the modules, than add reminder complete tags.    
     *  
     * @Stes 3 I
     * 
     * @return Array
     */
    public function varifyReminderTags() {
        $return = array("success" => false, "message" => trans("messages.operation_failed"));
        $infusionsoft = new InfusionsoftHelper();

        /** Verify user is registered or not */
        $userObj = $this->userModel->getByEmail($this->userEmail);
        if ($userObj != null) {

            /** Fetching user data from Infusion soft */
            $userContact = $infusionsoft->getContact($this->userEmail);

            if ($userContact != false) {
                /** Fetching user purchased courses */
                $products = $this->getProductArray($userContact["_Products"]);

                if (count($products) > 0) {
                    $module = new Module();

                    $isAnyModuleCompleted = $userObj->completed_modules()->count();

                    if ($isAnyModuleCompleted > 0) {
                        foreach ($products as $product) {
                            if ($product != "") {
                                $moduleList = $module->getModuleByCourseKey($product);
                                $moduleIds = $moduleList->pluck('id')->toArray();

                                /** Fetching last completed modules */
                                $lastCompletedModule = $userObj->getLastCompletedModuleById($moduleIds);
                                if ($lastCompletedModule != null) {
                                    $tmpModule = $module->getModuleByCourseKey($lastCompletedModule->course_key);
                                    $this->addTagByModuleId($userObj->contact_id, $tmpModule->first());
                                }
                            }
                        }
                    } else {
                        /** If Contact did not completed any Module than add reminder for 1st Module of purchase course */
                        foreach ($products as $product) {
                            $moduleList = $module->getModuleByCourseKey($product);
                            $this->addTagByModuleId($userObj->contact_id, $moduleList->first());
                            break;
                        }
                    }

                    /** Checking is all modules are completed, than set reminder is complete tag * */
                    $lastCourseId = $module->getLastModuleId();
                    if ($userObj->isAllModulesCompleted($lastCourseId) > 0) {
                        $this->addCompleteReminderTag($userObj->contact_id);
                    }
                    $return = array("success" => true, "message" => trans("messages.reminder_tags_updated"));
                } else {
                    $return = array("success" => false, "message" => trans("messages.no_purchse_done_by_user"));
                }
            }
        } else {
            $return = array("success" => false, "message" => trans("messages.user_not_found"));
        }

        return $return;
    }

    /**
     * Convert comma seperated purchase product string to array
     * 
     * @param type $products
     * @return type
     */
    private function getProductArray($products) {
        $tmpProducts = array();
        if ($products != "" && strpos($products, ',') != false) {
            $tmpProducts = explode(",", $products);
        }
        return $tmpProducts;
    }

    /**
     * Add Reminder tags for specified contact.
     * 
     * @param type $contactId
     * @param type $module
     */
    private function addTagByModuleId($contactId, $module) {
        
        $nextModule = $module->getNextModuleById($module->id);
        
        if ($nextModule != null) {
            $this->infusionsoft->addTag($contactId, $nextModule->tags->first()->tags_id);
        }
    }

    /**
     * Add Completed reminder tag for speficied contact
     * @param type $contactId
     */
    private function addCompleteReminderTag($contactId) {
        $this->infusionsoft->addTag($contactId, 154);
    }

}

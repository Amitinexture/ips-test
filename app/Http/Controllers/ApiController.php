<?php

namespace App\Http\Controllers;

use App\Http\Helpers\InfusionsoftHelper;
use App\Http\Helpers\UserReminderHelper;
use Illuminate\Http\Request;
use Response;
use App\User;
use App\Module;

class ApiController extends Controller {

    // Todo: Module reminder assigner

    public function exampleCustomer() {
        $infusionsoft = new InfusionsoftHelper();

        $uniqid = uniqid();

        $newObject = $infusionsoft->createContact([
            'Email' => $uniqid . '@test.com',
            "_Products" => 'ipa,iea'
        ]);
       
        $user = User::create([
                    'name' => 'Test ' . $uniqid,
                    'email' => $uniqid . '@test.com',
                    'password' => bcrypt($uniqid),
                    'contact_id' => $newObject
        ]);

        // attach IPA M1-3 & M5
        $user->completed_modules()->attach(Module::where('course_key', 'ipa')->limit(3)->get());
        $user->completed_modules()->attach(Module::where('name', 'IPA Module 5')->first());
        
        return $user;
    }

    /**
     * Add new contact verify it reminder tags.
     * @param type $email
     * @return type
     */
    public function exampleContactAdd($email) {

        $infusionsoft = new InfusionsoftHelper();
        $uniqid = uniqid();

        $newObject = $infusionsoft->createContact([
            'Email' => $email,
            "_Products" => 'ipa,iea'
        ]);

        $user = User::create([
                    'name' => 'Test ' . $uniqid,
                    'email' => $email,
                    'password' => bcrypt($email),
                    'contact_id' => $newObject
        ]);
        
        $reminderHelper = new UserReminderHelper($email);

        return Response::json($reminderHelper->varifyReminderTags());
    }
   
    /**
     * Add new tage to contacts
     * @param type $contact_id
     * @param type $tag_id
     * @return type
     */
    public function exampleTagAdd($contact_id, $tag_id) {
        $infusionsoft = new InfusionsoftHelper();
        return Response::json($infusionsoft->addTag($contact_id, $tag_id));
    }

    /**
     * Get contact details by email
     * @param type $email
     * @return type
     */
    public function exampleGetCustomerTags($email) {
        $infusionsoft = new InfusionsoftHelper();

        return Response::json($infusionsoft->getContact($email));
    }

    /**
     * The function will perform the validation for the module reminder and setup the correct tags for the module.
     * 
     * @param Request $request
     * @return type
     */
    public function moduleReminderAssigner(Request $request) {
        $email = $request->get('contact_email');

        $reminderHelper = new UserReminderHelper($email);

        return Response::json($reminderHelper->varifyReminderTags());
    }

}

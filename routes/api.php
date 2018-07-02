<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/api_example_customer', 'ApiController@exampleCustomer');
Route::get('/api_example_contact_add/{email}', 'ApiController@exampleContactAdd');
Route::get('/api_example_tag_add/{contact_id}/{tag_id}', 'ApiController@exampleTagAdd');
Route::get('/api_example_get_contact_tags/{email}', 'ApiController@exampleGetCustomerTags');

Route::post('/module_reminder_assigner', 'ApiController@moduleReminderAssigner');
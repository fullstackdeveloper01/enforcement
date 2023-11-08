<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\srmanagement\ServiceRequestController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\setup\SitesController;
use App\Http\Controllers\letter\LettersController;
use App\Http\Controllers\casemanagement\enviro\EnviroController;
use App\Http\Controllers\casemanagement\enviro\master\OffenceHowController;
use App\Http\Controllers\casemanagement\enviro\master\OffenceLocationPrefixController;
use App\Http\Controllers\casemanagement\enviro\master\AddressVerifiedByController;
use App\Http\Controllers\casemanagement\enviro\master\EthnicityController;
use App\Http\Controllers\casemanagement\enviro\master\OffenceLocationSuffixController;
use App\Http\Controllers\casemanagement\enviro\master\WeatherController;
use App\Http\Controllers\casemanagement\enviro\master\OffenderHairColourController;
use App\Http\Controllers\casemanagement\enviro\master\OffenderBuildController;
use App\Http\Controllers\casemanagement\enviro\master\IdShownController;
use App\Http\Controllers\casemanagement\enviro\master\VisibilityController;
use App\Http\Controllers\casemanagement\enviro\master\WriteOffCodeController;
use App\Http\Controllers\casemanagement\enviro\master\CancelCodeController;
use App\Http\Controllers\casemanagement\enviro\master\PaymentMethodController;
use App\Http\Controllers\casemanagement\enviro\master\LegislationController;
use App\Http\Controllers\casemanagement\enviro\master\TypeOfLandController;
use App\Http\Controllers\casemanagement\enviro\master\TypeOfDogController;
use App\Http\Controllers\casemanagement\enviro\master\DogSizeController;
use App\Http\Controllers\casemanagement\enviro\master\DogUnderController;
use App\Http\Controllers\casemanagement\enviro\master\BwcController;
use App\Http\Controllers\casemanagement\enviro\master\RegionController;
use App\Http\Controllers\casemanagement\enviro\master\OffenceController;
use App\Http\Controllers\casemanagement\enviro\master\OffenceGroupController;
use App\Http\Controllers\casemanagement\enviro\master\ManualRepresentationReasonController;
use App\Http\Controllers\casemanagement\enviro\master\RepresentationAcceptReasonController;
use App\Http\Controllers\casemanagement\enviro\master\RepresentationDeclineReasonController;
use App\Http\Controllers\casemanagement\enviro\master\ProducedWasteTransferController;
use App\Http\Controllers\casemanagement\enviro\master\WasteTypeController;
use App\Http\Controllers\casemanagement\enviro\master\ApplicantTypeController;
use App\Http\Controllers\casemanagement\enviro\master\CompanyRegisterdTypeController;
use App\Http\Controllers\casemanagement\enviro\master\RepresentationController;
use App\Http\Controllers\casemanagement\enviro\master\ServiceRequestTypeController;
use App\Http\Controllers\casemanagement\enviro\master\ServiceRequestReportedViaController;
use App\Http\Controllers\casemanagement\enviro\master\ServiceRequestClosedCodesController;
use App\Http\Controllers\casemanagement\enviro\master\PositionOfEmploymentController;
use App\Http\Controllers\casemanagement\enviro\master\ServiceRequestTaskTypeController;
use App\Http\Controllers\casemanagement\enviro\master\ServiceRequestTaskGroupController;
use App\Http\Controllers\API\PaymentsController;
use Illuminate\Support\Facades\Auth;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Notice Payment APIs
// GET COMPANY DETAILS
Route::get('/site/{name}', [PaymentsController::class, 'fetch_site_info']);
Route::POST('/search/FPN', [PaymentsController::class, 'search_fpn']);
Route::POST('/search/enviro', [PaymentsController::class, 'search_enviro']);
Route::POST('/payment/create', [PaymentsController::class, 'create_payment']);
Route::POST('/opayo/checkout', [PaymentsController::class, 'pay']);


Route::prefix('user')->name('user')->group(function () {
    Route::get('/',[UserController::class, 'index'])->name('list');
    Route::get('/{id}',[UserController::class, 'show'])->name('show');
    Route::put('/{id}',[UserController::class, 'update'])->name('update');
    Route::put('/{id}/status',[UserController::class, 'updateStatus'])->name('status');
    Route::post('/', [UserController::class, 'store'])->name('create');

    Route::get('/{id}/sites', [UserController::class, 'fetch_assigned_sites']);
    Route::post('/assign-site', [UserController::class, 'assign_site']);
    Route::post('/site/unlink', [UserController::class, 'unlink_assigned_site']);

});

Route::prefix('role')->name('role')->group(function () {
    Route::get('/',[RoleController::class, 'index'])->name('list');
    Route::get('/{id}',[RoleController::class, 'show'])->name('show');
    Route::post('/add',[RoleController::class, 'create'])->name('create');
    Route::put('{id}/edit',[RoleController::class, 'edit'])->name('edit');
    Route::put('/{id}/status',[RoleController::class, 'status'])->name('status');
    Route::delete('/{id}/delete',[RoleController::class, 'delete'])->name('delete');
    Route::get('role-permission/{id}',[RoleController::class, 'rolePermission'])->name('rolePermission');

    Route::put('{id}/permission/{pid}/status/{status}', [RoleController::class, 'updatePermission'])->name('updatePermission');
});

Route::prefix('company')->name('company')->group(function () {
    Route::get('/',[CompanyController::class, 'index'])->name('list');
    Route::get('/{id}',[CompanyController::class, 'show'])->name('show');
});

Route::prefix('permission')->name('permission')->group(function () {
    Route::get('/',[PermissionController::class, 'index'])->name('list');
});

Route::group(['namespace' => 'App\Http\Controllers\API'], function(){
    Route::post('login', 'Auth\LoginController@login')->name('user.login.submit');
    Route::post('verify', 'Auth\TwoFactorController@verify')->name('twofactor.verify');
    Route::get('verify/resend', 'Auth\TwoFactorController@resend')->name('twofactor.resend');
    
    Auth::routes();
    Route::middleware('auth:api')->group(function () {
        Route::get('logout', 'Auth\LoginController@logout')->name('user.logout');
    });
});

// Setup Routes Below
Route::get('/site/{id}/status', [SitesController::class, 'update_status'])->name('site.statuss.update');

Route::middleware('auth:api')->group(function () {
    Route::get('/sites', [SitesController::class, 'list'])->name('site.index');
    Route::post('/sites', [SitesController::class, 'create'])->name('site.create');
    Route::post('/site/slug/check', [SitesController::class, 'check_slug']);

    Route::get('/site/{id}/find', [SitesController::class, 'findById'])->name('site.find');
    Route::post('/site/{id}', [SitesController::class, 'update'])->name('site.update');
    
    Route::get('/site/{id}/zones', [SitesController::class, 'listZonesBySite'])->name('list.zone.all');
    Route::get('/zones/{id}', [SitesController::class, 'fetch_zones'])->name('zone.list');
    Route::post('/zones', [SitesController::class, 'create_zone'])->name('zone.create');
    Route::get('/zone/{id}/towns', [SitesController::class, 'fetch_towns']);

    Route::post('/sites/{id}/enviro/update', [SitesController::class, 'update_enviro_tab'])->name('enviroTab.update');
    Route::post('/sites/{id}/area/create', [SitesController::class, 'create_area'])->name('site.area.create');
    Route::get('/sites/{id}/areas', [SitesController::class, 'fetch_areas'])->name('site.area.fetch');
    Route::post('/sites/{id}/area/update', [SitesController::class, 'update_area'])->name('site.area.update');
    Route::post('/sites/area/{id}/delete', [SitesController::class, 'delete_area'])->name('site.area.delete');
    
    Route::post('/sites/{id}/zone/update', [SitesController::class, 'update_zones']);
    Route::post('/sites/zone/{id}/delete', [SitesController::class, 'delete_zones']);

    Route::get('/sites/{id}/offences', [SitesController::class, 'fetch_site_offences'])->name('site.offences.fetch');
    Route::post('/site-offence/update', [SitesController::class, 'update_offence'])->name('site.offences.update');
    Route::post('/site-offence/{id}/delete', [SitesController::class, 'delete_offence'])->name('site.offences.delete');
    Route::post('/sites/offences/{id}/status', [SitesController::class, 'change_site_offences_status'])->name('site.offences.change.status');

    Route::get('/officers/fetch', [UserController::class, 'fetch_officers']);
    Route::get('/offence-groups/fetch', [OffenceController::class, 'fetch_offence_groups']);
    Route::get('/admin-users', [UserController::class, 'fetch_admins']);
    Route::get('/sites/{site_id}/offence-type/{id}/fetch', [OffenceController::class, 'fetch_offence_types']);
    Route::get('/location/prefix/fetch', [OffenceLocationPrefixController::class, 'fetch_locs_prefix']);
    Route::get('/location/sufix/fetch', [OffenceLocationPrefixController::class, 'fetch_locs_sufix']);
    Route::get('/actions/fetch', [OffenceHowController::class, 'fetch_actions_list']);
    Route::get('/land/fetch', [TypeOfLandController::class, 'fetch_types']);
    Route::get('/visibility/fetch', [VisibilityController::class, 'fetch_visibilities']);
    Route::get('/weather/fetch', [WeatherController::class, 'fetch_weathers']);
    Route::get('/ethnicity/fetch', [EthnicityController::class, 'fetch_ethnicities']);
    Route::get('/address/proof/fetch', [AddressVerifiedByController::class, 'fetch_proof_address']);
    Route::get('/proof_ids/fetch', [IdShownController::class, 'fetch_proof_ids']);

    // Letters
    Route::get('/letters/groups', [LettersController::class, 'fetch_groups']);


});

// Service Request Route Below
Route::post('/createServiceRequest', [ServiceRequestController::class, 'createServiceRequest']);
Route::get('/getAllService', [ServiceRequestController::class, 'getAllService']);
Route::get('/getAllService/{id}', [ServiceRequestController::class, 'getAllService']);

// Enviro Routes Below
Route::get('/enviro', [EnviroController::class, 'index']);
Route::post('/enviro', [EnviroController::class, 'store']);
Route::get('/enviro/{id}', [EnviroController::class, 'show']);
Route::put('/enviro/{id}', [EnviroController::class, 'update']);
Route::delete('/enviro/{id}', [EnviroController::class, 'destroy']);

Route::get('/enviro/master/offencehow', [OffenceHowController::class, 'index']);
Route::post('/enviro/master/offencehow', [OffenceHowController::class, 'store']);
Route::put('/enviro/master/offencehow/{id}/status', [OffenceHowController::class, 'updateStatus']);
Route::put('/enviro/master/offencehow/{id}', [OffenceHowController::class, 'update']);

Route::get('/enviro/master/offencelocationprefix', [OffenceLocationPrefixController::class, 'index']);
Route::post('/enviro/master/offencelocationprefix', [OffenceLocationPrefixController::class, 'store']);
Route::put('/enviro/master/offencelocationprefix/{id}/status', [OffenceLocationPrefixController::class, 'updateStatus']);
Route::put('/enviro/master/offencelocationprefix/{id}', [OffenceLocationPrefixController::class, 'update']);

Route::get('/enviro/master/addressverifiedby', [AddressVerifiedByController::class, 'index']);
Route::post('/enviro/master/addressverifiedby', [AddressVerifiedByController::class, 'store']);
Route::put('/enviro/master/addressverifiedby/{id}/status', [AddressVerifiedByController::class, 'updateStatus']);
Route::put('/enviro/master/addressverifiedby/{id}', [AddressVerifiedByController::class, 'update']);

Route::get('/enviro/master/ethnicity', [EthnicityController::class, 'index']);
Route::post('/enviro/master/ethnicity', [EthnicityController::class, 'store']);
Route::put('/enviro/master/ethnicity/{id}/status', [EthnicityController::class, 'updateStatus']);
Route::put('/enviro/master/ethnicity/{id}', [EthnicityController::class, 'update']);

Route::get('/enviro/master/offencelocationsuffix', [OffenceLocationSuffixController::class, 'index']);
Route::post('/enviro/master/offencelocationsuffix', [OffenceLocationSuffixController::class, 'store']);
Route::put('/enviro/master/offencelocationsuffix/{id}/status', [OffenceLocationSuffixController::class, 'updateStatus']);
Route::put('/enviro/master/offencelocationsuffix/{id}', [OffenceLocationSuffixController::class, 'update']);

Route::get('/enviro/master/weather', [WeatherController::class, 'index']);
Route::post('/enviro/master/weather', [WeatherController::class, 'store']);
Route::put('/enviro/master/weather/{id}/status', [WeatherController::class, 'updateStatus']);
Route::put('/enviro/master/weather/{id}', [WeatherController::class, 'update']);

Route::get('/enviro/master/offenderhaircolour', [OffenderHairColourController::class, 'index']);
Route::post('/enviro/master/offenderhaircolour', [OffenderHairColourController::class, 'store']);
Route::put('/enviro/master/offenderhaircolour/{id}/status', [OffenderHairColourController::class, 'updateStatus']);
Route::put('/enviro/master/offenderhaircolour/{id}', [OffenderHairColourController::class, 'update']);

Route::get('/enviro/master/offenderbuild', [OffenderBuildController::class, 'index']);
Route::post('/enviro/master/offenderbuild', [OffenderBuildController::class, 'store']);
Route::put('/enviro/master/offenderbuild/{id}/status', [OffenderBuildController::class, 'updateStatus']);
Route::put('/enviro/master/offenderbuild/{id}', [OffenderBuildController::class, 'update']);

Route::get('/enviro/master/idshown', [IdShownController::class, 'index']);
Route::post('/enviro/master/idshown', [IdShownController::class, 'store']);
Route::put('/enviro/master/idshown/{id}/status', [IdShownController::class, 'updateStatus']);
Route::put('/enviro/master/idshown/{id}', [IdShownController::class, 'update']);

Route::get('/enviro/master/visibility', [VisibilityController::class, 'index']);
Route::post('/enviro/master/visibility', [VisibilityController::class, 'store']);
Route::put('/enviro/master/visibility/{id}/status', [VisibilityController::class, 'updateStatus']);
Route::put('/enviro/master/visibility/{id}', [VisibilityController::class, 'update']);

Route::get('/enviro/master/writeoffcode', [WriteOffCodeController::class, 'index']);
Route::post('/enviro/master/writeoffcode', [WriteOffCodeController::class, 'store']);
Route::put('/enviro/master/writeoffcode/{id}/status', [WriteOffCodeController::class, 'updateStatus']);
Route::put('/enviro/master/writeoffcode/{id}', [WriteOffCodeController::class, 'update']);

Route::get('/enviro/master/cancelcode', [CancelCodeController::class, 'index']);
Route::post('/enviro/master/cancelcode', [CancelCodeController::class, 'store']);
Route::put('/enviro/master/cancelcode/{id}/status', [CancelCodeController::class, 'updateStatus']);
Route::put('/enviro/master/cancelcode/{id}', [CancelCodeController::class, 'update']);

Route::get('/enviro/master/paymentmethod', [PaymentMethodController::class, 'index']);
Route::post('/enviro/master/paymentmethod', [PaymentMethodController::class, 'store']);
Route::put('/enviro/master/paymentmethod/{id}/status', [PaymentMethodController::class, 'updateStatus']);
Route::put('/enviro/master/paymentmethod/{id}', [PaymentMethodController::class, 'update']);

Route::get('/enviro/master/legislation', [LegislationController::class, 'index']);
Route::post('/enviro/master/legislation', [LegislationController::class, 'store']);
Route::put('/enviro/master/legislation/{id}/status', [LegislationController::class, 'updateStatus']);
Route::put('/enviro/master/legislation/{id}', [LegislationController::class, 'update']);

Route::get('/enviro/master/typeofland', [TypeOfLandController::class, 'index']);
Route::post('/enviro/master/typeofland', [TypeOfLandController::class, 'store']);
Route::put('/enviro/master/typeofland/{id}/status', [TypeOfLandController::class, 'updateStatus']);
Route::put('/enviro/master/typeofland/{id}', [TypeOfLandController::class, 'update']);

Route::get('/enviro/master/typeofdog', [TypeOfDogController::class, 'index']);
Route::post('/enviro/master/typeofdog', [TypeOfDogController::class, 'store']);
Route::put('/enviro/master/typeofdog/{id}/status', [TypeOfDogController::class, 'updateStatus']);
Route::put('/enviro/master/typeofdog/{id}', [TypeOfDogController::class, 'update']);

Route::get('/enviro/master/dogsize', [DogSizeController::class, 'index']);
Route::post('/enviro/master/dogsize', [DogSizeController::class, 'store']);
Route::put('/enviro/master/dogsize/{id}/status', [DogSizeController::class, 'updateStatus']);
Route::put('/enviro/master/dogsize/{id}', [DogSizeController::class, 'update']);

Route::get('/enviro/master/dogundercontrol', [DogUnderController::class, 'index']);
Route::post('/enviro/master/dogundercontrol', [DogUnderController::class, 'store']);
Route::put('/enviro/master/dogundercontrol/{id}/status', [DogUnderController::class, 'updateStatus']);
Route::put('/enviro/master/dogundercontrol/{id}', [DogUnderController::class, 'update']);

Route::get('/enviro/master/bwc', [BwcController::class, 'index']);
Route::post('/enviro/master/bwc', [BwcController::class, 'store']);
Route::put('/enviro/master/bwc/{id}/status', [BwcController::class, 'updateStatus']);
Route::put('/enviro/master/bwc/{id}', [BwcController::class, 'update']);

Route::get('/enviro/master/region', [RegionController::class, 'index']);
Route::post('/enviro/master/region', [RegionController::class, 'store']);
Route::put('/enviro/master/region/{id}/status', [RegionController::class, 'updateStatus']);
Route::put('/enviro/master/region/{id}', [RegionController::class, 'update']);

Route::get('/enviro/master/offence', [OffenceController::class, 'index']);
Route::post('/enviro/master/offence', [OffenceController::class, 'store']);
Route::put('/enviro/master/offence/{id}/status', [OffenceController::class, 'updateStatus']);
Route::put('/enviro/master/offence/{id}', [OffenceController::class, 'update']);
Route::get('/enviro/master/offence/{id}', [OffenceController::class, 'show']);

Route::get('/enviro/master/offencegroup', [OffenceGroupController::class, 'index']);
Route::post('/enviro/master/offencegroup', [OffenceGroupController::class, 'store']);
Route::put('/enviro/master/offencegroup/{id}/status', [OffenceGroupController::class, 'updateStatus']);
Route::put('/enviro/master/offencegroup/{id}', [OffenceGroupController::class, 'update']);
Route::get('/enviro/master/manualrepresentationreason', [ManualRepresentationReasonController::class, 'index']);
Route::post('/enviro/master/manualrepresentationreason', [ManualRepresentationReasonController::class, 'store']);
Route::put('/enviro/master/manualrepresentationreason/{id}/status', [ManualRepresentationReasonController::class, 'updateStatus']);
Route::put('/enviro/master/manualrepresentationreason/{id}', [ManualRepresentationReasonController::class, 'update']);

Route::get('/enviro/master/representationacceptreason', [RepresentationAcceptReasonController::class, 'index']);
Route::post('/enviro/master/representationacceptreason', [RepresentationAcceptReasonController::class, 'store']);
Route::put('/enviro/master/representationacceptreason/{id}/status', [RepresentationAcceptReasonController::class, 'updateStatus']);
Route::put('/enviro/master/representationacceptreason/{id}', [RepresentationAcceptReasonController::class, 'update']);

Route::get('/enviro/master/representationdeclinereason', [RepresentationDeclineReasonController::class, 'index']);
Route::post('/enviro/master/representationdeclinereason', [RepresentationDeclineReasonController::class, 'store']);
Route::put('/enviro/master/representationdeclinereason/{id}/status', [RepresentationDeclineReasonController::class, 'updateStatus']);
Route::put('/enviro/master/representationdeclinereason/{id}', [RepresentationDeclineReasonController::class, 'update']);


Route::get('/enviro/master/producedwastetransfer', [ProducedWasteTransferController::class, 'index']);
Route::post('/enviro/master/producedwastetransfer', [ProducedWasteTransferController::class, 'store']);
Route::put('/enviro/master/producedwastetransfer/{id}/status', [ProducedWasteTransferController::class, 'updateStatus']);
Route::put('/enviro/master/producedwastetransfer/{id}', [ProducedWasteTransferController::class, 'update']);

Route::get('/enviro/master/wastetype', [WasteTypeController::class, 'index']);
Route::post('/enviro/master/wastetype', [WasteTypeController::class, 'store']);
Route::put('/enviro/master/wastetype/{id}/status', [WasteTypeController::class, 'updateStatus']);
Route::put('/enviro/master/wastetype/{id}', [WasteTypeController::class, 'update']);


Route::get('/enviro/master/applicanttype', [ApplicantTypeController::class, 'index']);
Route::post('/enviro/master/applicanttype', [ApplicantTypeController::class, 'store']);
Route::put('/enviro/master/applicanttype/{id}/status', [ApplicantTypeController::class, 'updateStatus']);
Route::put('/enviro/master/applicanttype/{id}', [ApplicantTypeController::class, 'update']);

Route::get('/enviro/master/companyregisterdtype', [CompanyRegisterdTypeController::class, 'index']);
Route::post('/enviro/master/companyregisterdtype', [CompanyRegisterdTypeController::class, 'store']);
Route::put('/enviro/master/companyregisterdtype/{id}/status', [CompanyRegisterdTypeController::class, 'updateStatus']);
Route::put('/enviro/master/companyregisterdtype/{id}', [CompanyRegisterdTypeController::class, 'update']);

Route::get('/enviro/master/representation/list', [RepresentationController::class, 'index']);
Route::post('/enviro/master/representation', [RepresentationController::class, 'store']);
Route::post('/enviro/master/representation/search-fpn', [RepresentationController::class, 'searchFpn']);


Route::get('/enviro/master/servicerequesttype', [ServiceRequestTypeController::class, 'index']);
Route::get('/enviro/master/servicerequesttypeall', [ServiceRequestTypeController::class, 'list']);
Route::post('/enviro/master/servicerequesttype', [ServiceRequestTypeController::class, 'store']);
Route::put('/enviro/master/servicerequesttype/{id}/status', [ServiceRequestTypeController::class, 'updateStatus']);
Route::put('/enviro/master/servicerequesttype/{id}', [ServiceRequestTypeController::class, 'update']);

Route::get('/enviro/master/servicerequestreportedvia', [ServiceRequestReportedViaController::class, 'index']);
Route::post('/enviro/master/servicerequestreportedvia', [ServiceRequestReportedViaController::class, 'store']);
Route::put('/enviro/master/servicerequestreportedvia/{id}/status', [ServiceRequestReportedViaController::class, 'updateStatus']);
Route::put('/enviro/master/servicerequestreportedvia/{id}/backoffice', [ServiceRequestReportedViaController::class, 'updateBackOffice']);
Route::put('/enviro/master/servicerequestreportedvia/{id}/online', [ServiceRequestReportedViaController::class, 'updateOnline']);
Route::put('/enviro/master/servicerequestreportedvia/{id}', [ServiceRequestReportedViaController::class, 'update']);

Route::get('/enviro/master/servicerequestclosedcodes', [ServiceRequestClosedCodesController::class, 'index']);
Route::post('/enviro/master/servicerequestclosedcodes', [ServiceRequestClosedCodesController::class, 'store']);
Route::put('/enviro/master/servicerequestclosedcodes/{id}/status', [ServiceRequestClosedCodesController::class, 'updateStatus']);
Route::put('/enviro/master/servicerequestclosedcodes/{id}', [ServiceRequestClosedCodesController::class, 'update']);

Route::get('/enviro/master/positionofemployment', [PositionOfEmploymentController::class, 'index']);
Route::post('/enviro/master/positionofemployment', [PositionOfEmploymentController::class, 'store']);
Route::put('/enviro/master/positionofemployment/{id}/status', [PositionOfEmploymentController::class, 'updateStatus']);
Route::put('/enviro/master/positionofemployment/{id}', [PositionOfEmploymentController::class, 'update']);

Route::get('/enviro/master/servicerequesttasktype', [ServiceRequestTaskTypeController::class, 'index']);
Route::post('/enviro/master/servicerequesttasktype', [ServiceRequestTaskTypeController::class, 'store']);
Route::put('/enviro/master/servicerequesttasktype/{id}/status', [ServiceRequestTaskTypeController::class, 'updateStatus']);
Route::put('/enviro/master/servicerequesttasktype/{id}', [ServiceRequestTaskTypeController::class, 'update']);

Route::get('/enviro/master/{id}/tasktype', [ServiceRequestTaskTypeController::class, 'tasklistbysite']);

Route::get('/enviro/master/servicerequesttaskgroup', [ServiceRequestTaskGroupController::class, 'index']);
Route::post('/enviro/master/servicerequesttaskgroup', [ServiceRequestTaskGroupController::class, 'store']);
Route::get('/enviro/master/servicerequesttaskgroupall', [ServiceRequestTaskGroupController::class, 'list']);
Route::put('/enviro/master/servicerequesttaskgroup/{id}/status', [ServiceRequestTaskGroupController::class, 'updateStatus']);
Route::put('/enviro/master/servicerequesttaskgroup/{id}', [ServiceRequestTaskGroupController::class, 'update']);


/*
|--------------------------------------------------------------------------
| Mobile APP API Routes
|--------------------------------------------------------------------------
|
| Below api's are for the mobile application!
|
*/
Route::POST('/app/login', [\App\Http\Controllers\API\App\AuthController::class, 'login']);

Route::middleware('app.auth')->group(function () {
    Route::GET('/app/sites', [\App\Http\Controllers\API\App\FpnController::class, 'fetch_all_sites']);
    Route::POST('/app/enviro-data', [\App\Http\Controllers\API\App\FpnController::class, 'fetch_enviro_data']);
    Route::GET('/app/sites/{site_id}/offence/{id}/types', [\App\Http\Controllers\API\App\FpnController::class, 'fetch_offence_types']);
    Route::POST('/app/enviro', [\App\Http\Controllers\API\App\FpnController::class, 'create_enviro']);
});

/*
|---------------------------
| Zendesk call back url.
|---------------------------
*/
Route::post('/zendesk-call-back', [RepresentationController::class, 'handleZendeskCallBack']);

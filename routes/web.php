<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/main', function () {
    return view('welcome-react');
});

Route::get('/', function () {
    return view('nutrition.index');
});

Route::get('/nutrition-programme-areas', 'NutritionProgrammeAreasController@index')->name('nutrition.nutrition-programme-areas');
Route::get('/load-geojson', 'NutritionProgrammeAreasController@loadGeoJson');
Route::get('/load-organisation-unit-levels', 'NutritionProgrammeAreasController@loadOrganisationUnitLevels');
Route::get('/load-level-based-organisation-units', 'NutritionProgrammeAreasController@loadLevelBasedOrganisationUnits');
Route::get('/load-data-value-set', 'NutritionProgrammeAreasController@loadDataValueSetJoint');

Route::get('/analysis', function () {
    return view('nutrition.analysis');
});

// Route::get('/dashboard', function () {
//     return view('nutrition.dashboard');
// })->name('nutrition.dashboard');

Route::get('/platform', function () {
    return view('nutrition.platform');
})->name('nutrition.platform');

// ORGANIZATIONAL ROUTES
Route::get('/get_org_division', 'Helper\OrganisationController@getOrganizationDivisions');
// ORGANIZATIONAL ROUTES END

// PERIOD ROUTES
Route::get('/get_periods', 'Helper\PeriodController@getPeriodsMonthly');
// PERIOD ROUTES END

// DATA ELEMENT ROUTES
Route::get('/get_elements', 'Helper\DataElementController@getDataElements');
Route::get('/get_elements_all', 'Helper\DataElementController@getDataElementsAll');
Route::get('/get_elements_maternal', 'Helper\DataElementController@getDataElementsMaternal');
Route::get('/get_elements_children', 'Helper\DataElementController@getDataElementsChildren');
Route::get('/get_elements_joint', 'Helper\DataElementController@getDataElementsJoint');
Route::get('/get_category', 'Helper\DataElementController@getDataElementCategory');
Route::get('/get_category_joint', 'Helper\DataElementController@getDataElementCategoryJoint');
// Route::get('/get_category_mc', 'Helper\DataElementController@getDataElementCategoryMC');
Route::get('/get_data_value_set', 'Helper\DataElementController@getDataValueSet');
Route::get('/get_data_value_set_joint', 'Helper\DataElementController@getDataValueSetJoint');
// Route::get('/get_data_value_set_mc', 'Helper\DataElementController@getDataValueSetMC');

// DATA ELEMENT ROUTES END

// Route::get('/dashboard', 'Helper\OrganisationController@getOrganizationDivisions');

// Route::get('/', 'CurlController@testUrl');
Route::get('/accesstoken', 'CurlController@getAccessToken');
Route::get('/refreshtoken', 'CurlController@refreshToken');
Route::get('/createuser', 'CurlController@createAccessUser');
// Route::get('/createuser', 'CurlController@createAccessUser');
Route::get('/dataset/{id?}', 'ApiController@getDataSet');
Route::get('/datavalueset/{id?}', 'ApiController@getDataValueSet');
Route::get('/orgunit/{id?}', 'ApiController@getOrganizationUnit');
Route::get('/getorgunit/{id?}', 'ApiController@getOrganizationUnit');
Route::get('/periods', 'ApiController@getPeriods');
Route::get('/dataelement/{id?}', 'ApiController@getDataElements');
Route::get('/dataValueSet/{id?}', 'ApiController@getDataSetValues');

Route::get('/get_data_set/{id?}', 'AnalysisController@getDataSet');
Route::get('/get_data_element/{id?}', 'AnalysisController@getDataElements');


// Updating database

Route::get('/update_anc_counsel', 'Helper\UpdateDBController@updateANCCounsel');

Route::group(['prefix' => 'import-data', 'namespace' => 'ImportData', 'as' => 'import-data.'], function() {
	Route::get('/cc-cr-additional-food-supplimentation', 'CcCrAdditionalFoodSupplimentationController@import');
	Route::get('/imci-wasting', 'ImciWastingController@import');
	Route::get('/imci-stunting', 'ImciStuntingController@import');
	Route::get('/importer', 'ImporterController@import');
	Route::get('/organisation-unit-importer', 'OrganisationUnitImporterController@import');
	Route::get('/category-option-combo-importer', 'CategoryOptionComboImporterController@import');
});

Route::group(['namespace' => 'Frontend', 'as'=>'frontend.'], function() {
	Route::get('/dashboard', 'DashboardController@indexAction')->name('dashboard');

	// Outputs 
	Route::get('/outputs', 'OutputController@indexAction')->name('outputs');
	Route::get('/outputs/maternal', 'OutputController@indexAction')->name('outputs.maternal');
	Route::post('/outputs/maternal-main-chart', 'OutputController@maternalMainChart')->name('outputs.maternal.mainchart');

	// Output Child
	Route::get('/outputs/child', 'OutputController@indexChild')->name('outputs.child');

	// Outcomes
	Route::get('/outcomes', 'OutcomeController@secondIndexAction')->name('outcomes');
	Route::post('/outcomes/get-outcome-data', 'OutcomeController@getOutcomeData')->name('get-outcome-data');	
});

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
	return redirect()->route('frontend.dashboard');
});

Route::group(['prefix' => 'import-data', 'namespace' => 'ImportData', 'as' => 'import-data.'], function() {
	Route::get('/cc-cr-additional-food-supplimentation', 'CcCrAdditionalFoodSupplimentationController@import');
	Route::get('/imci-wasting', 'ImciWastingController@import');
	Route::get('/imci-stunting', 'ImciStuntingController@import');
	Route::get('/scheduleImport', 'ImporterController@scheduleImport');
	Route::get('/mapImport', 'ImporterController@mapImport');
	Route::get('/organisation-unit-importer', 'OrganisationUnitImporterController@import');
	Route::get('/category-option-combo-importer', 'CategoryOptionComboImporterController@import');
	Route::get('/getDistrict', 'ImporterController@importDistrict');
	// Updating database
	Route::get('/update_anc_counsel', 'Helper\UpdateDBController@updateANCCounsel');
	
	//Importers
	// Route::get('/importer', 'ImporterController@import');
	// Route::get('/csvimport', 'ImporterController@importDGFPCsv');
	// Route::get('/truncate-import-tables', 'ImporterController@truncateImportTables');
});


Route::group(['namespace' => 'Frontend', 'as'=>'frontend.'], function() {
	Route::get('/dashboard', 'DashboardController@indexAction')->name('dashboard');
	Route::get('/dashboard_maps', 'DashboardController@getGeoJsons')->name('dashboard-maps');
	Route::get('/dashboard_percents', 'DashboardController@getPercentTrend')->name('dashboard-percents');
	Route::get('/dashboard_specific_map', 'DashboardController@getMapData')->name('dashboard-specific-map');
	Route::get('/dashboard/circular-chart', 'DashboardController@ajaxCircularChart')->name('dashboard.circular-chart');

	// Outputs 
	Route::get('/outputs', 'OutcomeController@indexAction')->name('outcomes');
	Route::get('/outputs/maternal', 'OutcomeController@indexAction')->name('outcomes.maternal');
	Route::get('/outputs/maternal/load-period-wise-data', 'OutcomeController@loadPeriodWiseMaternalData')->name('outcomes.maternal.load-period-wise-data');
	Route::post('/outputs/maternal-main-chart', 'OutcomeController@maternalMainChart')->name('outcomes.maternal.mainchart');

	// Output Child
	Route::get('/outputs/child', 'OutcomeController@indexChild')->name('outcomes.child');
	Route::get('/outputs/child/load-period-wise-data', 'OutcomeController@loadPeriodWiseChildData')->name('outcomes.child.load-period-wise-data');

	// Outcomes
	Route::get('/impacts', 'ImpactController@secondIndexAction')->name('impacts');
	Route::post('/impacts/get-outcome-data', 'ImpactController@getOutcomeData')->name('get-outcome-data');	

	// Technical Standards
	Route::get('/technical-standard', 'TechnicalStandardController@indexAction')->name('technical-standard');
});

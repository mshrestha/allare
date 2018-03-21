<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        
        <style>
            .mycol {
                height: 500px;
                overflow-x: hidden;
                overflow-y: scroll;
            }
            
            .myformcontrol {
                float: left;
                width: 85% !important;
            }

            .loading {
                float: right;
                line-height: 21px;
            }
        </style>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.0/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group datasets_wrapper">
	                        <span class="col-sm-4 control-span" for="dataset">Data Sets</span>
	                        <div class="col-sm-8">
		                        <select name="dataset" class="datasets_select myformcontrol" id="dataset_select_id">
		                        	<option value="">Select Data Set</option>
		                        </select>
		                        <span class="loading">Loading</span>
		                      </div>
                        </div>

                        <div class="form-group periods_wrapper">
                            <span class="col-sm-4 control-span" for="period">Periods</span>
                            <div class="col-sm-8">
                                <select name="period" class="periods_select myformcontrol" id="period_select_id" multiple>
                                    <option value="">Select Periods</option>
                                </select>
                                <span class="loading">Loading</span>
                              </div>
                        </div>

                        <div class="form-group organization_units_wrapper">
	                        <span class="col-sm-4 control-span" for="organization_unit">Organization Units</span>
	                        <div class="col-sm-8">
		                        <select name="organization_unit" class="organization_units_select myformcontrol" id="organization_unit_select_id">
                                    <option value="">Select Organization Level</option>
                                    @for($i=0; $i<7; $i++)
                                        <option value="LEVEL-{{$i+1}}">Level {{$i+1}}</option>
                                    @endfor
		                        	
		                        </select>
		                        <!-- <span class="loading">Loading</span> -->
		                      </div>
                        </div>

                        <div class="form-group dataelements_wrapper">
	                        <span class="col-sm-4 control-span" for="dataelement">Data Elements</span>
	                        <div class="col-sm-8">
		                        <select name="dataelement" class="dataelements_select myformcontrol" id="dataelement_select_id" multiple>
		                        	<option value="">Select Data Element</option>
		                        </select>
		                        <span class="loading">Loading</span>
		                      </div>
                        </div>

                         <div class="form-group">
                            <button class="btn btn-primary pull-right" id="submitDataSet">Submit</button>
                        </div>

                       <!--  <div class="form-group indicator_groups_wrapper">
                            <label>Indicator Groups</label>
                            <select name="indigator_group" class="indicator_groups_select myformcontrol">
                                <option value="">Select Indicator Group</option>
                            </select>
                            <span class="loading">Loading</span>
                        </div>

                        <div class="form-group">
                            <label>Indicators</label>
                            <select name="indicator" class="indicators_select myformcontrol">
                                <option value="">Select Indicator</option>
                            </select>
                            <span class="loading">Loading</span>
                        </div>

                        <div class="form-group period_types_wrapper">
                            <label>Periods</label>
                            <select name="period" class="periods_select myformcontrol">
                                <option value="">Select Periods</option>
                            </select>
                            <span class="loading">Loading</span>
                        </div> -->
                       
                    </div> <!-- col -->
                </div> <!-- row -->
                <div id="dataDiv">
                </div>
            </div>
        </div>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>
        var loading = $('.loading')

        $(document).ready(function() {  
            getDataSets();
            getPeriods();
   //          $('.organization_units_wrapper').hide();
			// $('.dataelements_wrapper').hide();
            // getIndicatorGroups();
            // getPeriodTypes();
            
            // $('.indicator_groups_select').on('change', function() {
            //     getIndicators($(this).val());
            // });
        })

        function getDataSets() {
        	$.ajax({
                type: 'get',
                url: '/get_data_set',
                success: function (res) {
                	dataSets = res["dataSets"];
                	console.log(dataSets);
                	for(data in dataSets) {
                		$(".datasets_select").append('<option value="'+ data +'">'+ dataSets[data] +'</option>')
                	}
									// $.each(dataSets, function(){
									    
									// })
				        	$('.organization_units_wrapper').show();
                  $('.datasets_wrapper .loading').hide()
         //          console.log('Organisation units loaded')
                },
                error: function (res) {
                  console.log('failed')
                }
            })
        }

        function getPeriods() {
            $.ajax({
                type: 'get',
                url: '/periods',
                success: function (res) {
                    dataSets = res["periods"];
                    console.log(dataSets);
                    for(data in dataSets) {
                        $(".periods_select").append('<option value="'+ dataSets[data] +'">'+ dataSets[data] +'</option>')
                    }
                                    // $.each(dataSets, function(){
                                        
                                    // })
                            // $('.organization_units_wrapper').show();
                  $('.periods_wrapper .loading').hide()
         //          console.log('Organisation units loaded')
                },
                error: function (res) {
                  console.log('failed')
                }
            })
        }

        $('#dataset_select_id').change(function(){
        	dataSet = ($('#dataset_select_id').val())
        	$.ajax({
                type: 'get',
                url: '/get_data_element/'+dataSet,
                success: function (res) {
                	// dataSets = res["dataSets"];
                	// console.log(res['id']);
                    for(i = 0; i < res.length; i++) {
                        $(".dataelements_select").append('<option value="'+ res[i].id +'">'+ res[i].name +'</option>')
                    }
                	// for(data in dataSets) {
                	// 	$(".dataelements_select").append('<option value="'+ dataSets[data] +'">'+ dataSets[data] +'</option>')
                	// }
									// $.each(dataSets, function(){
									    
									// })
                  $('.dataelements_wrapper .loading').hide()
                
                },
                error: function (res) {
                  console.log('failed')
                }
            })
        });


        $('#submitDataSet').click(function(){
            dataSet = ($('#dataset_select_id').val())
            period =  ($('#period_select_id').val())
            dataElement =  ($('#dataelement_select_id').val())
            organization = ($('#organization_unit_select_id').val());
            console.log(period);
            $.ajax({
                type: 'get',
                url: '/get_data_value_set/',
                data: {dataSet: dataSet, period: period, organization: organization, dataElement: dataElement},
                success: function (res) {
                  // console.log(res);
                  // output = '';
                  // returned = res.returnedData
                  // for (var i = 0; i < returned.length; i++) {
                  //     resObject = returned[i];
                  //     output += '<tr><th>'+DataElement+'</th><td>'+resObject['dataElement']+'</td></tr><tr><th>'+CategoryOption+'</th><td>'+resObject['categoryOptionCombos']+'</td></tr><tr><th>'+Organization+'</th><td>'+resObject['orgUnit']+'</td></tr><tr><th>'+Period+'</th><td>'+resObject['period']+'</td></tr><tr><th>'+Value+'</th><td>'+resObject['value']+'</td></tr>';
                  // };
                  // console.log(output);
                  $('#dataDiv').html(res);
                },
                error: function (res) {
                  console.log('failed')
                }
            })
        });
        
    
        </script>
    </body>
</html>
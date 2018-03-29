<div class="main-chart">
	<div class="row row-no-padding">
	    {{-- Selectors --}}
	    <div class="col-md-3">
	        <div class="side-filter-div">
	            <div class="input-group mb-3">
	                <div class="input-group-prepend">
	                    <label class="input-group-text" for="division-id">Divisions</label>
	                </div>
	                <select class="custom-select" id="division-id">
	                    <option value="">Divisions</option>
	                	@foreach($organisation_units as $organisation_unit)
	                    <option data-central-id="{{ $organisation_unit->central_api_id }}" data-community-id="{{ $organisation_unit->community_api_id }}">{{ $organisation_unit->name }}</option>
	                	@endforeach
	                </select>

	            </div>

	            <div class="input-group mb-3">
	                <div class="input-group-prepend">
	                    <label class="input-group-text" for="period-id">Periods</label>
	                </div>
	                <select class="custom-select" id="period-id">
	                    <option value="">Periods</option>
	                    <option value="LAST_MONTH">1 month</option>
	                    <option value="LAST_6_MONTHS">6 months</option>
	                    @foreach($periods as $key => $period)
	                    <option value="{{ $key }}">{{ $period }}</option>
	                    @endforeach
	                </select>
	            </div>
	            <div class="input-group mb-3">
	                <div class="input-group-prepend">
	                    <label class="input-group-text" for="indicator-id">Indicators</label>
	                </div>
	                <select class="custom-select" id="indicator-id" name="indicator-id">
	                </select>
	            </div>

	            <div class="input-group mb-3">
	                <div class="input-group-prepend">
	                    <label class="input-group-text">Departments</label>
	                </div>
	                <select class="custom-select" id="department-id">
	                    <option value="">Departments</option>
	                    <option value="both">Both</option>
	                    <option value="DGHS">DGHS</option>
	                    <option value="DGFP">DGFP</option>
	                </select>
	            </div>
	            
	            {{-- <div class="input-group mb-3">
	                <div class="input-group-prepend">
	                    <label class="input-group-text" for="affected-id">Affected</label>
	                </div>
	                <select class="custom-select" id="affected-id">
	                </select>
	            </div> --}} 

	            <div class="input-group mb-3">
	                <button type="button" class="btn btn-primary" id="submit-platform-btn">Submit</button>
	            </div>
	        </div>
	    </div>
	    {{-- Bargraph --}}
	    <div class="col-md-9">
	        <div class="bargraph-div">
	            <canvas id="myChart" width="400" height="400"></canvas>
	        </div>
	    </div>
	</div>
</div>
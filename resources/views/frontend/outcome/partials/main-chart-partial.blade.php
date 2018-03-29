<div class="main-chart" style="margin-bottom: 20px;">
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
	                </select>
	            </div>
	            <div class="input-group mb-3">
	                <div class="input-group-prepend">
	                    <label class="input-group-text" for="programme-id">Indicators</label>
	                </div>
	                <select class="custom-select" id="programme-id">
	                </select>
	            </div>
	            <div class="input-group mb-3">
	                <div class="input-group-prepend">
	                    <label class="input-group-text">Departments</label>
	                </div>
	                <select class="custom-select" id="department-id">
	                    <option value="">Departments</option>
	                    <option value="">Both</option>
	                    <option value="">DGHS</option>
	                    <option value="">DGFP</option>
	                </select>
	            </div>
	            {{--
	            <div class="input-group mb-3">
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
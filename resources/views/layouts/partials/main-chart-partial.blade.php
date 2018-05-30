<div class="main-chart">
	<div class="row no-gutters">
		{{-- Selectors --}}
		<div class="col-md-3 col-xl-2">
			<div class="side-filter-div">
				{{ Form::open(['id' => 'main-chart-form', 'method' => 'POST']) }}
				<div class="input-group">
					<select class="custom-select" id="organisation_unit_id" name="organisation_unit_id" required>
						<option value="">Divisions</option>
						@foreach($organisation_units as $organisation_unit)
						@if($organisation_unit->name != 'X organizationunits for delete')
							<option value="{{ $organisation_unit->central_api_id }}.{{ $organisation_unit->community_api_id }}">{{ $organisation_unit->name }}</option>
							@if($organisation_unit->name == 'Barisal Division')
            		<option class="pl-5" value="xNcsJeRMUCM.xNcsJeRMUCM">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Barguna District</option>
            		<option class="pl-5" value="uOU0jtyD1PZ.uOU0jtyD1PZ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Barisal District</option>
            	@endif
						@endif
						@endforeach
					</select>

				</div>

				<div class="input-group">
					<select class="custom-select" name="period_id" id="period_id" required>
						<option value="">Periods</option>
						<option value="LAST_MONTH">Last month</option>
						<option value="LAST_6_MONTHS">Last 6 months</option>
						@foreach($periods as $key => $period)
						<option value="{{ $key }}">{{ $period }}</option>
						@endforeach
					</select>
				</div>
				<div class="input-group">
					<select class="custom-select" id="indicator_id" name="indicator_id" required>
						<option value="">Indicators</option>
						@foreach($indicators as $key => $indicator)
						<option value="{{ $key }}">{{ $indicator }}</option>
						@endforeach
					</select>
				</div>

				<div class="input-group">
					<select class="custom-select" id="department_id" name="department_id">
						<option value="">Departments</option>
						<option value="both">Both</option>
						<option value="DGHS">DGHS</option>
						<option value="DGFP">DGFP</option>
					</select>
				</div>


				<div class="input-group mb-3 submit-input-group">
					<button type="submit" class="btn btn-secondary btn-sm btn-block rounded-0" id="submit-platform-btn">Submit</button>
				</div>
				{{ Form::close() }}
				<div class="chart-legend">
					<div class="row">
						<div class="col-6 pr-0"><div class="legend"><div class="dghs">DGHS</div></div></div>
						<div class="col-6 pr-0"><div class="legend"><div class="dgfp">DGFP</div></div></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-9 col-xl-10">
			<div class="bargraph-div">
				<canvas id="mainChart" width="400" height="400"></canvas>
			</div>
		</div>
	</div>
</div>
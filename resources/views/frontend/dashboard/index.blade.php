@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row">
			<!-- content -->
			<div class="col-sm-9">
				<h3>Our goal is to reduce malnutrition and improve nutritional status of  the peoples of Bangladesh with special emphasis to the children, adolescents, pregnant & lactating women, elderly, poor and underserved population of both rural and urban area in line with National Nutrition Policy 2015.</h3>
				<div class="output-dashboard">
					<h2>Outputs</h2>
					<div id="maternal-health">
						<h3>Maternal Health</h3>
						<div class="row">
							<div class="col-sm-4"></div>
							<div class="col-sm-4"></div>
							<div class="col-sm-4"></div>
						</div>
					</div>
					<div id="child-health">
						<h3>Child Health</h3>
						<div class="row">
							<div class="col-sm-4"></div>
							<div class="col-sm-4"></div>
							<div class="col-sm-4"></div>
						</div>
					</div>
				</div>
				<div class="outcome-dashboard">
					<h2>Outcome</h2>
					<div class="row">
						@foreach($outcomes as $key => $analysis)
							@include('layouts.partials.dashboard-outcomes-partial')
						@endforeach
					</div>
				</div>
			</div>
			<!-- sidebar -->
			<div class="col-sm-3">
				<h1>Inputs</h1>
				<div class="sideblock">
					<h4>Reporting</h4>
					<p>Departments that have submitted the reports for the month of April.</p>
					<h4 class="bg-green">FWC</h4>
					<h4 class="bg-green">IMCI-N</h4>
					<h4 class="bg-red">SAM</h4>
					<p>View results from past months</p>
				</div>
				@foreach($sidebarContents as $key => $sidebarContent)
					@include('layouts.partials.dashboard-sidebar-partial')
				@endforeach
			</div>

		</div>
	</div>
@endsection
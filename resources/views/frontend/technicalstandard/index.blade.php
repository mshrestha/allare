@extends('layouts.app')

@section('content')
<div class="container">
	<div class="input-wrapper tab-outer-wrapper">
		<div class="container">
			<div class="standard-wrapper-inner">
				<div class="row">
					<div class="col-12"><div class="box-heading float-left">Technical Standards</div></div></div>
						<div class="row">
							<div class="col-12">
								<ul class="nav nav-tabs" id="standard-tab" role="tablist">
									@php
					  				$cardCounter = 1;
					  			@endphp
					  			@foreach($standards as $firstKey => $standard)
					  				<li class="nav-item">
									    <a class="nav-link @if($cardCounter == 1) active @endif" id="tablink{{$cardCounter}}" data-toggle="tab" href="#tab{{$cardCounter}}" role="tab" aria-controls="home" aria-selected="true">{{$firstKey}}</a>
									  </li>
									  @php
									  	$cardCounter += 1;
									  @endphp
					  			@endforeach
								</ul>
								<div class="tab-content" id="myTabContent">
									@php
					  				$cardCounter = 1;
					  			@endphp
					  			@foreach($standards as $firstKey => $standard)
						  			<div class="tab-pane fade show @if($cardCounter == 1) active @endif" id="tab{{$cardCounter}}" role="tabpanel" aria-labelledby="tablink{{$cardCounter}}">
							  			<table class="table table-striped">
							  				<tr>
							        		<th>Level</th>
							        		<td class="" colspan="4">{{$standard['level']}}</td>
							        	</tr>
							        	<tr>
							        		<th>Indicator</th>
							        		<td colspan="4">{{$standard['indicator']}}</td>
							        	</tr>
							        	<tr>
							        		<th>Definition</th>
							        		<td colspan="4">{{$standard['definition']}}</td>
							        	</tr>
							        	<tr>
							        		<th>Target</th>
							        		<td colspan="4">{{$standard['target']}}</td>
							        	</tr>
							        	<tr>
							        		<th>Frequency</th>
							        		<td colspan="4">{{$standard['frequency']}}</td>
							        	</tr>
							        	<tr>
							        		<th class="has-border">Collection point</th>
							        		<th class="has-border">Person responsible for recording data</th>
							        		<th class="has-border">Person responsible for reporting data </th>
							        		<th class="has-border">Methods for recording</th>
							        		<th class="has-border">Methods for recording</th>
							        	</tr>
							        	@foreach($standard['table_data'] as $table_data)
							        		<tr>
							        			@foreach($table_data as $datumKey => $datum)
							        				@if($datumKey == 0)
							        					<th class="has-border">{{$datum}}</th>
							        				@else
							        					<td class="has-border">{{$datum}}</td>
						        					@endif
							        			@endforeach
							        		</tr>
							        	@endforeach
							        		<tr>
							        			<td colspan="5">
							        				<h4>Technical Standards</h4>
							        				<p>{{$standard['text']}}</p>
							        			</td>
							        		</tr>
							        </table>
					  				</div>
					  				@php
									  	$cardCounter += 1;
									  @endphp
					  			@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
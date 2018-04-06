<div class="sideblock">
	<h3>{{$key}}</h3>
	<p>{{$sidebarContent['title']}}</p>
	@foreach($sidebarContent['items'] as $itemKey => $item)
		<div class="sideblock-item">
			<div class="row">
				<div class="col-2 col-sm-6 col-lg-2 col-md-6 text-center mx-auto">
					<img src="{{asset('images/'.$item['image'])}}" class="item item-image mb-2">
				</div>
				<div class="col-2 col-sm-6 col-lg-3 col-md-6 text-center mx-auto">
					<span class="item item-percent text-center">{{$item['percent']}}</span>
				</div>
				<div class="col-8 col-sm-12 col-lg-7">
					<span class="item item-text">{{$item['text']}}</span>
				</div>
			</div>
		</div>
	@endforeach
</div>
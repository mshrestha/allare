<div class="sideblock">
	<h3>{{$key}}</h3>
	<p>{{$sidebarContent['title']}}</p>
	@foreach($sidebarContent['items'] as $itemKey => $item)
		<div class="sideblock-item">
			<img src="{{asset('images/'.$item['image'])}}" class="item item-image">
			<span class="item item-percent">{{$item['percent']}}</span>
			<span class="item item-text">{{$item['text']}}</span>
		</div>
	@endforeach
</div>
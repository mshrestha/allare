@foreach($returnedData as $data)
	<tr>
		<td>{{$data['dataElement']}}</td>
		<td>{{$data['value']}}</td>
	</tr>
@endforeach
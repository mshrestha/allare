

<!-- Tab links -->
<div class="tab">
	@for($i = 0; $i < count($divisionArr); $i++)
		<button class="tablinks" onclick="openCity(event, '{{$divisionArr[$i]}}')">{{$divisionArr[$i]}}</button>
	@endfor
  
  <!-- <button class="tablinks" onclick="openCity(event, 'Paris')">Paris</button>
  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Tokyo</button> -->
</div>

<!-- Tab content -->
@for($i = 0; $i < count($divisionArr); $i++)
	<div id="{{$divisionArr[$i]}}" class="tabcontent">
  	<table>
  		<thead>
  			<tr>
  					<th>Period</th>
	  			@for($j = 0; $j < count($elementsArr); $j++)
						<th>{{$elementsArr[$j]}}</th>
	  			@endfor
  			</tr>
  		</thead>
  		<tbody>
  			
					@foreach($actualData as $datarow)
					<tr>
						@foreach($datarow as $data)
							@if($data['organisation'] == $divisionArr[$i])
								<td>{{$data['value']}}</td>
							@endif
						@endforeach
						</tr>
					@endforeach
				
  		</tbody>
  	</table>
	</div>
@endfor
<!-- <div id="London" class="tabcontent">
  <h3>London</h3>
  <p>London is the capital city of England.</p>
</div>

<div id="Paris" class="tabcontent">
  <h3>Paris</h3>
  <p>Paris is the capital of France.</p> 
</div>

<div id="Tokyo" class="tabcontent">
  <h3>Tokyo</h3>
  <p>Tokyo is the capital of Japan.</p>
</div>
 -->
<style>
.tabcontent {
    overflow: scroll;
}
/* Style the tab */
.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}

/* Style the buttons that are used to open the tab content */
.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}
</style>

<script>
function openCity(evt, cityName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Decision Matrix Generator</title>

    <!-- Bootstrap core CSS -->
<link href="/graphics/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Decision Matrix Generator</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
      </li>
  </div>
</nav>

<main role="main" class="container">
  <br />

  <!-- Main engine script for the SPA -->
  <script>
    // Create the data table for the management of the data
    var dataTable = [];

    // Create the basic data insertion thingy.
    function addCI() {
	    // Create the array for the new value
	    // Always assume that the first value is enabled
	    var nuCI = [
		1,
		document.getElementById('ci').value,
		document.getElementById('eSV').value,
		document.getElementById('eUV').value,
		document.getElementById('eOV').value,
		document.getElementById('dSV').value,
		document.getElementById('dUV').value,
		document.getElementById('dOV').value
	];

	    // Add the data to the global variable
	    dataTable.push(nuCI);

	    // Rebuild the table data
	    buildTable();
    }

    function getAverage(dataPoints) {
	// variables
	var total = 0;
	var length = dataPoints.length;

	dataPoints.forEach(function(dp) {
		// add the total of the the datapoints
		total = parseInt(total) + parseInt(dp);
	});

	// Return the values
	return (total / length);
    }

    function buildTable() {
	// Create a variable to stuff the HTML text into     
	var htmlText = "<table class=\"table\"><tr><td>Decision Point</td><td>Enabled</td><td>Security Value</td><td>User Value</td><td>Operations Value</td>";

	// consolidate the row html
	var dataRows = '';

	// get the SV, UV, and OV for averaging
	var SV = [];
	var UV = [];
	var OV = [];
	
	// insert the data
	for (i = 0; i < dataTable.length; i++) {
		var ci = dataTable[i];
		var rowText = '';

		// If enabled, create a row with the enabled values and update the score arrays
		if (ci[0] == 1) {
			rowText = '<tr><td>' + ci[1] + '</td><td><select id="'+ i +'" onChange="toggleCI(\''+i+'\')"><option value="1"selected>Enabled</option><option value="0">Disabled</option></select></td><td>' + ci[2] + '</td><td>' + ci[3] + '</td><td>' + ci[4] + '</td></tr>';
			SV.push(ci[2]);
			UV.push(ci[3]);
			OV.push(ci[4]);
		// if disabled, create a row with the disabled values
		} else {
			rowText = '<tr><td>' + ci[1] + '</td><td><select id="'+ i +'" onChange="toggleCI(\''+i+'\')"><option value="1">Enabled</option><option value="0" selected>Disabled</option></select></td><td>' + ci[5] + '</td><td>' + ci[6] + '</td><td>' + ci[7] + '</td></tr>';
			SV.push(ci[5]);
			UV.push(ci[6]);
			OV.push(ci[7]);
		}

		// Insert the updated row into the table
		dataRows += rowText;
	}

	// Get averages for the S,U,and O values
	var svAVG = getAverage(SV);
	var uvAVG = getAverage(UV);
	var ovAVG = getAverage(OV);

	// Create the summary row
	var summaryRow = '<tr><th colspan="2">Summary</th><th>' + svAVG + '</th><th>' + uvAVG + '</th><th>' + ovAVG + '</th></tr>';

	// Aggregate everything together
	htmlText += summaryRow;
	htmlText += dataRows;
	htmlText += "</table>";

	// Insert the table into the DOM
	document.getElementById('outTable').innerHTML = htmlText;
    }

    function toggleCI(arrayID) {

	// Toggle the enabled bit
    	if ( dataTable[arrayID][0] == 0 ) {
		dataTable[arrayID][0] = 1;
	} else {
		dataTable[arrayID][0] = 0;
	}
    	// rebuild the table;
	buildTable();
    }
  </script>

    <!-- Create the input table -->
    <table class="table">
      <tr>
	<td data-toggle="tooltip" data-placement="top" title="Add a new configuration item">
	    Add
        </td>
	<td data-toggle="tooltip" data-placement="top" title="Policy, configuration, or decision point.">
	  Decision Point
	</td>
	<td data-toggle="tooltip" data-placement="top" title="Security value if enabled.">
	  eSV
	</td>
	<td data-toggle="tooltip" data-placement="top" title="User value if enabled.">
	  eUV
	</td>
	<td data-toggle="tooltip" data-placement="top" title="Operations value if enabled.">
	  eOV
	</td>
	<td data-toggle="tooltip" data-placement="top" title="Security value if disabled.">
	  dSV
	</td>
	<td data-toggle="tooltip" data-placement="top" title="User value if disabled.">
	  dUV
	</td>
	<td data-toggle="tooltip" data-placement="top" title="Operations value if disabled.">
	  dOV
	</td>
      </tr>
      <tr>
	<td><input id="submit" type="submit" class="btn btn-outline-success" value="+" onClick="addCI()"></td>
	<td><input id="ci" type="text" name="ci" value=""></input></td>
	<td>
	  <select id="eSV" name="eSV">
  	    <option value="1">1</option>
  	    <option value="2">2</option>
  	    <option value="3" selected>3</option>
  	    <option value="4">4</option>
  	    <option value="5">5</option>
	  </select>
	</td>
	<td>
	  <select id="eUV" name="eUV">
  	    <option value="1">1</option>
  	    <option value="2">2</option>
  	    <option value="3" selected>3</option>
  	    <option value="4">4</option>
  	    <option value="5">5</option>
	  </select>
	</td>
	<td>
	  <select id="eOV" name="eOV">
  	    <option value="1">1</option>
  	    <option value="2">2</option>
  	    <option value="3" selected>3</option>
  	    <option value="4">4</option>
  	    <option value="5">5</option>
	  </select>
	</td>
	<td>
	  <select id="dSV" name="dSV">
  	    <option value="1">1</option>
  	    <option value="2">2</option>
  	    <option value="3" selected>3</option>
  	    <option value="4">4</option>
  	    <option value="5">5</option>
	  </select>
	</td>
	<td>
	  <select id="dUV" name="dUV">
  	    <option value="1">1</option>
  	    <option value="2">2</option>
  	    <option value="3" selected>3</option>
  	    <option value="4">4</option>
  	    <option value="5">5</option>
	  </select>
	</td>
	<td>
	  <select id="dOV" name="dOV">
  	    <option value="1">1</option>
  	    <option value="2">2</option>
  	    <option value="3" selected>3</option>
  	    <option value="4">4</option>
  	    <option value="5">5</option>
	  </select>
	</td>
      </tr>
    </table>

    <div id="outTable">

    </div>

</main><!-- /.container -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="/graphics/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script></body>
</html>


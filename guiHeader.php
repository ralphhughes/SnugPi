<!DOCTYPE html>
<html>
  
  <head>
    <meta charset="utf-8">
	  <script type="text/javascript" src="//code.jquery.com/jquery-2.0.2.js"></script>

	 <script src="http://code.highcharts.com/highcharts.js"></script>
	 
	 <script>

var objDate = new Date();

// Converts a relative time such as 15:03 to the same time today measured in milliseconds since
// the unix epoch
function timeToMillis(hours, minutes) {
	var objDate = new Date();
	return Date.UTC(objDate.getUTCFullYear(),objDate.getUTCMonth(),objDate.getUTCDate(),hours,minutes);
	
}

var scheduled_temps = [
		[timeToMillis(0,0),0],		// Start of day
		
		// Values will be inserted from database
		
		[timeToMillis(15,00), 0],
		[timeToMillis(15,00), 21],
        [timeToMillis(18,00), 21],
		[timeToMillis(18,00), 0],
		
		[timeToMillis(24,0),0],	// End of day
    ];

function fakeDate() {
	for (var hours=0; hours < objDate.getUTCHours(); hours++) {
		
	}
}	
	
var inside_temps = [
	[timeToMillis(0,0),14],		// Start of day
	[timeToMillis(15,00),15],
	[timeToMillis(15,30),18],
	[timeToMillis(16,00),20],
	[timeToMillis(16,30),21],
	[timeToMillis(17,00),21.5],
	[timeToMillis(17,30),20.5],
	[timeToMillis(18,00),21],
	[timeToMillis(18,30),18.5],
	[timeToMillis(19,00),16],
	[timeToMillis(19,30),15],
];

//var outside_temps = fakeData();	
	
$(function () {
	Highcharts.setOptions({                                            // This is for all plots, change Date axis to local timezone
		global : {
			useUTC : false
		}
	});

    $('#container').highcharts({
    title: {
        text: null
    },
    credits: false,
    xAxis: {
        type: 'datetime',
        tickInterval: 3600 * 1000,
        min: Date.UTC(objDate.getUTCFullYear(),objDate.getUTCMonth(),objDate.getUTCDate(),0,0),
        max: Date.UTC(objDate.getUTCFullYear(),objDate.getUTCMonth(),objDate.getUTCDate(),24,0),
    },

    yAxis: {
        title: {
            text: null
        }
    },

    tooltip: {
        crosshairs: true,
        shared: false,
        valueSuffix: '°C',
		xDateFormat: '%H:%M',
    },

    legend: {
    },

    series: [{
        name: 'Inside Temp',
        data: inside_temps,
        zIndex: 1,
		color: '#FF0000',
        marker: {
            enabled: false
        }
    }, {
        name: 'Scheduled',
        data: scheduled_temps,
        type: 'area',
        lineWidth: 0,
        color: Highcharts.getOptions().colors[0],
        fillOpacity: 0.3,
        zIndex: 0,
        marker: {
            enabled: false
        }
    }]
    });
});

</script>

</head>

<body>
<table>
    <tr><td>Today</td><td><div id="container" style="height: 300px"></div></td></tr>
    <tr><td>Yesterday</td><td><div id="container" style="height: 300px"></div></td></tr>

</table>
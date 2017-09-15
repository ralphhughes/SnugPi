<!doctype html>
<html>
<head>
    <title>JQuery mobile - slider tests</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<style>
		.time-slider input[type=number] {
			display: none; 
		}
		.time-slider .startTimeLabel{
			position: relative;
			top: -38px;
		}
		.timeRangeSlider {
			position: relative;
		}
		.timeRangeSlider .startTimeLabel{
			position: absolute;
			top: 30px;    
		}

		.timeRangeSlider .endTimeLabel{
			position: absolute;
			top: 30px;
			right: 0;
			left: auto;
		}
	</style>
	<script>
		$(document).on("pagecreate", "#page1", function(){

			
			$("#sliderTime").on("change", function(){
				var time = IntToTime($(this).val());
				$("#theTime .startTimeLabel").val(time);
				$("#theTime .ui-slider-handle").prop("title", time);
			});
			
			$("#startTime").on("change", function(){
				var time = IntToTime($(this).val());
				$(this).closest(".timeRangeSlider").find(".startTimeLabel").val(time);
				$(this).closest(".timeRangeSlider").find(".ui-slider-handle").eq(0).prop("title", time);
			});
			$("#endTime").on("change", function(){
				var time = IntToTime($(this).val());
				$(this).closest(".timeRangeSlider").find(".endTimeLabel").val(time);
				$(this).closest(".timeRangeSlider").find(".ui-slider-handle").eq(1).prop("title", time);
			});
			
			
			$("#startTime").trigger("change");
			$("#endTime").trigger("change");
			$("#sliderTime").trigger("change");
			
		});

		function IntToTime(val){
			var hours = parseInt( val / 60 );
			var min = val - (hours * 60);
			var time = (hours < 10 ? '0' + hours : hours) + ':' + (min < 10 ? '0' + min : min);
			return time;
		}
	</script>
</head>
<body>
    <div data-role="page" id="page1">
 
 
        <div role="main" class="ui-content">
            <form action="updateSchedule.php?action=add" method="POST" data-ajax="false">
                    <fieldset data-role="collapsible" data-collapsed="false" data-collapsed-icon="carat-d" data-expanded-icon="carat-u">
                            <legend>Add\Edit time period</legend>
                            <label for="desiredTemp">Temperature:</label>
                            <input data-clear-btn="false" name="desiredTemp" id="desiredTemp" min="5" max="30" step="0.5" value="20" type="number" required>

                            <div class="timeRangeSlider">
                                    <div id="theTimeRange" class="time-slider" data-role="rangeslider">
                                            <label for="startTime">Time Range:</label>
                                            <input type="range" name="startTime" id="startTime" min="0" max="1440" value="540" step="5"/>
                                            <label for="endTime">Time Range:</label>
                                            <input type="range" name="endTime" id="endTime" min="0" max="1440" value="1020" step="5" />
                                    </div>
                                    <input type="text" data-role="none" class="startTimeLabel ui-shadow-inset ui-body-inherit ui-corner-all ui-slider-input" value="" disabled />
                                    <input type="text" data-role="none" class="endTimeLabel ui-shadow-inset ui-body-inherit ui-corner-all ui-slider-input" value="" disabled />
                            </div>
                            <input type="hidden" name="isTemporaryBoost" id="isTemporaryBoost" value="0"/>
                    </fieldset>					
                    <button data-role="none">Submit</button>
            </form>
        </div><!-- /content -->
 
        <div data-role="footer">
            <h4>Ralphius 2017</h4>
        </div><!-- /footer -->
 
    </div><!-- /page -->
</body>
</html>
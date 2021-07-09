	/**/
			function calcRoute() {
		  var selectedMode = 'DRIVING';
		  var request = {
			  origin: myStartOrigin,
			  destination: myEndOrigin,
			  // Note that JavaScript allows us to access the constant
			  // using square brackets and a string value as its
			  // "property."
			  travelMode: google.maps.TravelMode[selectedMode]
		  };
		  directionsService.route(request, function(response, status) {
			if (status == 'OK') {
			  directionsRenderer.setDirections(response);
			}
		  });
		}
		
		function getDistance(country,limit_miles,limit_km)
		{
		
			var service = new google.maps.DistanceMatrixService();
			service.getDistanceMatrix(
			  {
				origins: [myStartOrigin],
				destinations: [myEndOrigin],
				travelMode: 'DRIVING',
			  }, callback);

			function callback(response, status) {
			  // See Parsing the Results for
			  // the basics of a callback function.
			  var distances = response.rows[0].elements[0].distance;
			  var durations = response.rows[0].elements[0].duration;
			  console.log(response);
			  try{

				console.log(distances.text);

				console.log('metere',distances.value);
				var miles=(distances.value/1000)*0.62137;//Math.round();
				miles=Math.round(miles)//miles.toFixed(2);
				var kilomtere=distances.value/1000;//Math.round();
				kilomtere=Math.round(kilomtere);//kilomtere.toFixed(2);

				console.log('kilomtere',kilomtere);
				console.log('miles',miles);
				
				if(country="US"){
					if(miles > limit_miles){
						$(".out-of-rang").show();
						$(".checkout-sbmt").hide();
					}
				}
				else{
					if(kilomtere > limit_km){
						$(".out-of-rang").show();
						$(".checkout-sbmt").hide();
					}
				}

				
			  $("#distanceandtime").html("Total Distance: "+miles+" mi, Drive Time: "+durations.text);
			  $("#form_distance").val(distances.value);
			  }catch( e){
			  	$(".out-of-rang").show();
				$(".checkout-sbmt").hide();
				  console.log(e);
			  }
			}
		}
jQuery(document).ready(
	function() {
		var preset = [64, 192];
		jQuery( "#slider-range" ).slider({
			range: true,
			min: 0,
			max: 255,
			values: preset,
			slide: function( event, ui ) {
				document.ia.react(event, ui);
				// console.log(event);
			},
			stop: function( event, ui ) {
				document.ia.refresh(event, ui);
				// console.log(event);
			},
		});
		document.ia.react(null, {values:preset});
		// jQuery( "#image1" ).load("/drupal/ia/test/ajax");
	}
);

document.ia = {
	react: function(event, ui) {
		var low = ui.values[ 0 ]/255;
		low *= 10000;
		low = Math.floor(low) / 100; // pct...
		var high = ui.values[ 1 ]/255;
		high *= 10000;
		high = Math.floor(high) / 100; // pct...

		jQuery( "#amount" ).val( low + "% - " + high +"%" );
	},
	refresh: function(event, ui) {
		// console.log(new Date().getTime() - document.ia.lastActive);
		// if (new Date().getTime() - document.ia.lastActive < 480) return;
		jQuery.ajax({
			url: "/drupal/ia/test/ajax",
			type: "POST",
			data : {
				verb : "chroma2map",
				low : ui.values[ 0 ],
				high : ui.values[ 1 ],
			},
			success: function(data, textStatus, jqXHR) {
				//data - response from server
				// alert('Hi!');
				// console.log(data);
				
				jQuery('#image1').html(data.image);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				// error has occured
				alert('Error');
				// console.log(jqXHR);
			},
		});
	}

// Philip

google.maps.event.addDomListener(window, 'load', init); // run init() at window load event

function init() {
	// hard saved themes
	let mapThemes = {
		Default: null,
		Dark: [{elementType:'geometry',stylers:[{color:'#242f3e'}]},{elementType:'labels.text.stroke',stylers:[{color:'#242f3e'}]},{elementType:'labels.text.fill',stylers:[{color:'#746855'}]},{featureType:'administrative.locality',elementType:'labels.text.fill',stylers:[{color:'#d59563'}]},{featureType:'poi',elementType:'labels.text.fill',stylers:[{color:'#d59563'}]},{featureType:'poi.park',elementType:'geometry',stylers:[{color:'#263c3f'}]},{featureType:'poi.park',elementType:'labels.text.fill',stylers:[{color:'#6b9a76'}]},{featureType:'road',elementType:'geometry',stylers:[{color:'#38414e'}]},{featureType:'road',elementType:'geometry.stroke',stylers:[{color:'#212a37'}]},{featureType:'road',elementType:'labels.text.fill',stylers:[{color:'#9ca5b3'}]},{featureType:'road.highway',elementType:'geometry',stylers:[{color:'#746855'}]},{featureType:'road.highway',elementType:'geometry.stroke',stylers:[{color:'#1f2835'}]},{featureType:'road.highway',elementType:'labels.text.fill',stylers:[{color:'#f3d19c'}]},{featureType:'transit',elementType:'geometry',stylers:[{color:'#2f3948'}]},{featureType:'transit.station',elementType:'labels.text.fill',stylers:[{color:'#d59563'}]},{featureType:'water',elementType:'geometry',stylers:[{color:'#17263c'}]},{featureType:'water',elementType:'labels.text.fill',stylers:[{color:'#515c6d'}]},{featureType:'water',elementType:'labels.text.stroke',stylers:[{color:'#17263c'}]}],
		MidnightCommander: [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"color":"#000000"},{"lightness":13}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#144b53"},{"lightness":14},{"weight":1.4}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#08304b"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#0c4152"},{"lightness":5}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#0b434f"},{"lightness":25}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"color":"#0b3d51"},{"lightness":16}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"}]},{"featureType":"transit","elementType":"all","stylers":[{"color":"#146474"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#021019"}]}],
		ShadesOfGrey: [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}],
		WY: [{"featureType":"all","elementType":"geometry.fill","stylers":[{"weight":"2.00"}]},{"featureType":"all","elementType":"geometry.stroke","stylers":[{"color":"#9c9c9c"}]},{"featureType":"all","elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"landscape","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#eeeeee"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#7b7b7b"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#c8d7d4"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#070707"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]}],
	};

	// search for selected theme in the saved themes object
	let theme = map_settings.theme;
	for (themes in mapThemes) {
		if (theme === themes) {
			theme = mapThemes[themes];
			break;
		}
	}
	
	// if no match was found, it probably means it's the custom option, try parsing it...
	if (typeof theme === 'string') {
		try {
			theme = JSON.parse(theme);
		} catch (e) {
			console.log(e + '\n\nIf you get this error you have likely insserted an invalid style array, check the input and try again');
		}
	}

	const marker_path = map_settings.marker_image;
	const markers = map_settings.markers ? map_settings.markers : {
		content: 'Medieinstitutet AB',
		name: 'Drottninggatan 4',
		lat: 55.607058,
		lng: 13.020996,
	};
	const zoom = parseFloat(map_settings.zoom ? map_settings.zoom : 6);
	const controls = map_settings.controls ? map_settings.controls : {
		fullscreenControl: false,
		streetViewControl: false,
		mapTypeControl: false,
		rotateControl: false,
		scaleControl: false,
		zoomControl: true,
	};
    const mapOptions = {
        center: new google.maps.LatLng(55.607058, 13.020996), // default center point in case geolocation is turned off
		fullscreenControl: controls.fullscreenControl,
		streetViewControl: controls.streetViewControl,
		mapTypeControl: controls.mapTypeControl,
		rotateControl: controls.rotateControl,
		scaleControl: controls.scaleControl,
		zoomControl: controls.zoomControl,
        styles: theme,
        zoom: zoom,
    };
    const markerIcon = {
        scaledSize: new google.maps.Size(25, 25),
        size: new google.maps.Size(25, 25),
        url: marker_path,
    }
    const mapElement = document.getElementById('map');
    const map = new google.maps.Map(mapElement, mapOptions);
	const infoWindow = new google.maps.InfoWindow();

	// add markers
	let markersArray = [];
	let outletsHTML = '';
	for (let i = 0; i < markers.length; i++) {
		let marker = new google.maps.Marker({
			position: new google.maps.LatLng(markers[i].lat, markers[i].lng),
			title: markers[i].name,
			optimized: false,
			icon: markerIcon,
			map: map,
		});
		markersArray.push(marker);

		// custom marker info window content
		let markerContent = markers[i].content ? `<p class="marker-content">${markers[i].content}</p>` : '';
		let markerHTML = `
			<div class="marker-wrapper">
				<h6 class="marker-header">${markers[i].name}</h6>
				${markerContent}
			</div>
		`;

		// add click event listener for every marker
		google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
				infoWindow.setContent(markerHTML);
				infoWindow.open(map, marker);
				map.panTo({
					lat: parseFloat(markers[i].lat),
					lng: parseFloat(markers[i].lng),
				});
			}
      	})(marker, i));

		// create .outlets HTML
		outletsHTML += `
			<button class="outlet" data-lat="${markers[i].lat}" data-lng="${markers[i].lng}">
				<span class="outlet-text">${markers[i].name}</span>
				<img class="outlet-arrow" src="https://i.imgur.com/hhZai5a.png" />
			</button>
			<hr class="outlet-hr" />
		`;
	}
	// fill .outlets with the buttons
	$('.outlets').html(outletsHTML);
	
	$('.outlet').each(function(i) {
		let markerContent = markers[i].content ? `<p class="marker-content">${markers[i].content}</p>` : '';
		let markerHTML = `
			<div class="marker-wrapper">
				<h6 class="marker-header">${markers[i].name}</h6>
				${markerContent}
			</div>
		`;
		$(this).click(function() {
			infoWindow.setContent(markerHTML);
			infoWindow.open(map, markersArray[i]);
			map.setZoom(11);
		});
	});

	//infoWindow.open(map, test[0]);

	// change center to clicked location
	$('.outlet').click(function() {
		map.panTo({
			lat: parseFloat($(this).attr('data-lat')),
			lng: parseFloat($(this).attr('data-lng')),
		});
	});

	// if user accepts geolocation, center map on their position
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			map.panTo({
				lat: position.coords.latitude,
				lng: position.coords.longitude
			});
		});
	}
}
// Philip

if (document.getElementById('map')) google.maps.event.addDomListener(window, 'load', map_init); // only load map if #map exists 

function map_init() {
	let theme = '';
	if (map_theme) {
		try {
			theme = JSON.parse(map_theme.style);
		} catch (e) {
			console.log(e + '\n\nInvalid theme style array, check the input and try again');
		}
	}

	const enableInfoWindow = map_settings.enableInfoWindow === '1' ? true : false;
	const locations_list = map_settings.locations || false;
	const markers = map_markers || [{
		content: 'Medieinstitutet AB',
		name: 'Drottninggatan 4',
		lat: 55.607058,
		lng: 13.020996,
	}];
	const zoom = parseFloat(map_settings.zoom != null ? map_settings.zoom : 6);
	const controls = map_settings.controls || {
		fullscreenControl: false,
		streetViewControl: false,
		mapTypeControl: false,
		rotateControl: false,
		scaleControl: false,
		zoomControl: true,
	};
    const mapOptions = {
        center: new google.maps.LatLng(markers[0].lat, markers[0].lng), // default center point in case geolocation is turned off
		fullscreenControl: controls.fullscreenControl,
		streetViewControl: controls.streetViewControl,
		mapTypeControl: controls.mapTypeControl,
		rotateControl: controls.rotateControl,
		scaleControl: controls.scaleControl,
		zoomControl: controls.zoomControl,
        styles: theme,
        zoom: zoom,
    };
    const mapElement = document.getElementById('map');
    const map = new google.maps.Map(mapElement, mapOptions);
	let infoWindow;
	if (enableInfoWindow) infoWindow = new google.maps.InfoWindow();

	// add markers
	let outletsHTML = '';
	let markersArray = [];
	for (let i = 0; i < markers.length; i++) {
		let marker = new google.maps.Marker({
			position: new google.maps.LatLng(markers[i].lat, markers[i].lng),
			title: markers[i].name,
			icon: {
				scaledSize: new google.maps.Size(markers[i].size, markers[i].size),
				size: new google.maps.Size(markers[i].size, markers[i].size),
				url: markers[i].icon,
			},
			map: map,
		});
		markersArray.push(marker);

		// custom marker info window content
		let markerContent = markers[i].content ? markers[i].content : '';
		let markerHTML = `
			<div class="marker-wrapper">
				<h6 class="marker-title">${markers[i].name}</h6>
				<div class="marker-content">${markerContent}</div>
			</div>
		`;

		// add click event listener for every marker
		google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
				if (enableInfoWindow) {
					infoWindow.setContent(markerHTML);
					infoWindow.open(map, marker);
				}
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
			</button>
		`;
	}

	if (locations_list) {
		// fill .outlets with the buttons
		document.querySelector('.outlets').innerHTML = outletsHTML;
		
		// add marker click handler and HTML content
		let buttons = document.getElementsByClassName('outlet');
		for (let i = 0; i < buttons.length; i++) {
			let markerContent = markers[i].content ? markers[i].content : '';
			let markerHTML = `
				<div class="marker-wrapper">
					<h6 class="marker-title">${markers[i].name}</h6>
					<div class="marker-content">${markerContent}</div>
				</div>
			`;
			buttons[i].addEventListener('click', function() {
				if (enableInfoWindow) {
					infoWindow.setContent(markerHTML);
					infoWindow.open(map, markersArray[i]);
				}
				map.setZoom(11);
			});

			// change center to clicked location
			buttons[i].addEventListener('click', function() {
				map.panTo({
					lat: parseFloat(buttons[i].getAttribute('data-lat')),
					lng: parseFloat(buttons[i].getAttribute('data-lng')),
				});
			});
		}
	}

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
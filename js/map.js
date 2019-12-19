// Philip

google.maps.event.addDomListener(window, 'load', init); // run init() at window load event

function init() {
	const marker_url = map_marker.marker_url;
    const mapOptions = {
		fullscreenControl: false,
		mapTypeControl: false,
		rotateControl: false,
		scaleControl: false,
        zoom: 8,
        center: new google.maps.LatLng(55.607058, 13.020996), // default center point in case geolocation is turned off
        styles: [
            {
                "featureType": "all",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "saturation": 36
                    },
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 40
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 16
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 20
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 17
                    },
                    {
                        "weight": 1.2
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 20
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 21
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 17
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 29
                    },
                    {
                        "weight": 0.2
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 18
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 16
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 19
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 17
                    }
                ]
            }
        ]
    };

    const markerIcon = {
        url: marker_url,
        scaledSize: new google.maps.Size(20, 20),
        size: new google.maps.Size(20, 20),
    }
    const mapElement = document.getElementById('map');
    const map = new google.maps.Map(mapElement, mapOptions);
	const infoWindow = new google.maps.InfoWindow();

	// locations for the markers
	const locations = [
		{
			name: 'Kommendantsvägen 10',
			lat: 56.050794, 
			lng: 14.156656,
		},
		{
			name: 'Drottninggatan 4',
			lat: 55.607058,
			lng: 13.020996,
		},
		{
			name: 'Kungliga slottet',
			lat: 59.3268215,
			lng: 18.0717194,
		},
		{
			name: 'New York City',
			lat: 40.6976637,
			lng: -74.119764,
		},
		{
			name: 'Pitcairn Islands',
			lat: -24.4786052,
			lng: -128.8550564,
		},
		{
			name: 'North Pole',
			lat: 84.9999726,
			lng: -135.0006867,
		},
		{
			name: 'Mount Everest',
			lat: 27.9881388,
			lng: 86.9162203,
		},
		{
			name: 'The Black Sea',
			lat: 46.8933231,
			lng: 9.3275701,
		},
		{
			name: 'IKEA Älmhult',
			lat: 56.5356848,
			lng: 14.1227405,
		},
	];

	let outletsHTML = '';

	// add markers
	for (let i = 0; i < locations.length; i++) {
		let marker = new google.maps.Marker({
			position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
			title: locations[i].name,
			optimized: false,
			icon: markerIcon,
			map: map,
		});

		// add click event listener for every marker
		google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
				infoWindow.setContent(locations[i].name);
				infoWindow.open(map, marker);
			}
      	})(marker, i));

		// create .outlets HTML
		outletsHTML += `
			<button class="outlet" data-lat="${locations[i].lat}" data-lng="${locations[i].lng}">
				<span class="outlet-text">${locations[i].name}</span>
				<img class="outlet-arrow" src="https://i.imgur.com/hhZai5a.png" />
			</button>
			<hr class="outlet-hr" />
		`;
	}

	// fill .outlets with the buttons
	$('.outlets').html(outletsHTML);

	// change center to clicked location
	$('.outlet').click(function() {
		map.setCenter({
			lat: parseFloat($(this).attr('data-lat')),
			lng: parseFloat($(this).attr('data-lng')),
		});
	});

	// if user accepts geolocation, center map on their position
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			let pos = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			};
			map.setCenter(pos);
		});
	}
}
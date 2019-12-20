// Philip

google.maps.event.addDomListener(window, 'load', init); // run init() at window load event

function init() {
	const marker_path = map_settings.marker_image;
	const markers = map_settings.markers;
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
        scaledSize: new google.maps.Size(20, 20),
        size: new google.maps.Size(20, 20),
        url: marker_path,
    }
    const mapElement = document.getElementById('map');
    const map = new google.maps.Map(mapElement, mapOptions);
	const infoWindow = new google.maps.InfoWindow();


	// add markers
	let outletsHTML = '';
	for (let i = 0; i < markers.length; i++) {
		let marker = new google.maps.Marker({
			position: new google.maps.LatLng(markers[i].lat, markers[i].lng),
			title: markers[i].name,
			optimized: false,
			icon: markerIcon,
			map: map,
		});

		// add click event listener for every marker
		google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
				infoWindow.setContent(markers[i].name);
				infoWindow.open(map, marker);
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
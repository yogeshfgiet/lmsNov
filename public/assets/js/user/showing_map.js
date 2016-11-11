/**
 * Created by majuansari on 21/10/15.
 */

$(document).ready(function () {
    $.fn.mapInitialize(showingsData);
});

/**
 * Initialiasing map
 * @param showingsData
 */
$.fn.mapInitialize = function (showingsData) {
    window.showingsData = showingsData;
    var mapType = "ROADMAP";
    var windowHeight = $(window).height();
    $("#showings_map").css({height: windowHeight});
    var iniLat = 0;
    var iniLong = 0;
    var mapOptions = {
        center: new google.maps.LatLng(iniLat, iniLong),
        zoom: 2,
        minZoom: 2,
        mapTypeId: google.maps.MapTypeId[mapType],
        disableDefaultUI: true,
        mapTypeControl: false,
        zoomControl: true,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.SMALL,
            position: google.maps.ControlPosition.TOP_LEFT
        }

    };
    window.map = new google.maps.Map(document.getElementById("showings_map"), mapOptions);


    //Function to close the infowindow on marker click
    google.maps.event.addListener(map, 'click', function () {
        if (infowindow)
            infowindow.close();
    });

    var markers = [];

    var markersForEachLatlong = [];


    var map_size = new google.maps.Size(-140, 0);
    var info_map_size = new google.maps.Size(1, 1);

    var myOptions = {
        content: '<div class="popup"> fgfgdfgdfgdfgdf</div>'
        ,disableAutoPan: false
        ,maxWidth: 0
        ,pixelOffset: map_size
        ,boxStyle: {
            width: "280px"
        }
        ,closeBoxMargin: "2px 2px 2px 2px"
        ,closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif"
        ,infoBoxClearance: info_map_size
        ,isHidden: false
        ,pane: "floatPane"
        ,enableEventPropagation: false
    };
    var infowindow = new InfoBox(myOptions);

	var markerBounds = new google.maps.LatLngBounds();
    $.each(showingsData, function (index, value) {

       
        if (typeof value.lat_long != "undefined" && value.lat_long.length > 0) {
            var latLongJson = value.lat_long;
            var latLongData = null;
            try {
                latLongData = JSON.parse(latLongJson);
                if (latLongData != null && latLongData.lat != null && latLongData.long !== null) {
                    //bounds.extend(latlng);
                    markersForEachLatlong[latLongData.lat + "_" + latLongData.lng] = typeof markersForEachLatlong[latLongData.lat + "_" + latLongData.lng] != "undefined" ? markersForEachLatlong[latLongData.lat + "_" + latLongData.lng] + "_" + value.id : value.id;
					
                    var latlng = new google.maps.LatLng(latLongData.lat,
                        latLongData.lng);
                    //  var marker = new google.maps.Marker({'position': latLng});
					markerBounds.extend(latlng);
                    var marker = new google.maps.Marker({
                        position: latlng,
                        address: value.address,
                        show_id: value.showing_id,
       
                        start_time: value.start_time,
                        end_time: value.end_time,
                        id: markersForEachLatlong[latLongData.lat + "_" + latLongData.long]
                    });

                    google.maps.event.addListener(marker, 'click', function () {
                        if (infowindow) {
                            infowindow.close();

                        }
                        infowindow.open(map, marker);
                        loadInfoWindowContent(infowindow,marker);

                    });
                    markers.push(marker);
                }
            } catch (e) {
                console.log("json lat long value cant be parsed for " + value.id);
            }
        }
    });


    //Marker cluster options
    var mcOptions = {
        gridSize: 40,
        maxZoom: 11
    };

    var markerCluster = new MarkerClusterer(map, markers, mcOptions);
	map.fitBounds(markerBounds);
}
/**
 * Loading infowindow
 * @param infowindow
 * @param marker
 */
var loadInfoWindowContent = function (infowindow, marker) {
    google.maps.event.addListener(infowindow, 'domready', function () {
        var $visibleInfoWindow = $(".popup:visible");
        $visibleInfoWindow.html(getInfoWindowContent(marker));
        google.maps.event.clearListeners(infowindow, 'domready')
    });
}
/**
 * Getting contents for infowindow
 * @param marker
 * @returns {*|marker.address}
 */
var getInfoWindowContent = function (marker) {
    var content = '<p>' + marker.address + '</p>' +
        '<p> Start Time: ' + marker.start_time +
        '<br/> End Time: ' + marker.end_time +
       '</p>'+
       '<center><a style="cursor:pointer; color:white " onmouseover=this.style.color="gray" onMouseOut=this.style.color="white" onclick="viewShowing('+ marker.show_id +')">View Showing</a></center>';
        
       
    return content;
}
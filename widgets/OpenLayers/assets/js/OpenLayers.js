/**
 * Created with JetBrains PhpStorm.
 * User: sebastian
 * Date: 05.01.15
 * Time: 20:36
 * To change this template use File | Settings | File Templates.
 */

function initOpenLayer(cities, center, map_id, imagesPath) {

    console.log(imagesPath);

    var lonlat = new OpenLayers.LonLat(center.lng, center.lat).transform(
            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
            new OpenLayers.Projection("EPSG:900913") // to Spherical Mercator
            );

    var overlay = new OpenLayers.Layer.Vector('Overlay', {
        styleMap: new OpenLayers.StyleMap({
            title: '${tooltip}'
        })
    });

    map = new OpenLayers.Map({
        div: map_id,
        projection: "EPSG:4326",
        layers: [new OpenLayers.Layer.OSM(), overlay],
        center: lonlat
    });


    var markers = new OpenLayers.Layer.Markers("Markers");

    var size = new OpenLayers.Size(21, 25);
    var offset = new OpenLayers.Pixel(-(size.w / 2), -size.h);


    var markersLayer = new OpenLayers.Layer.Vector('Overlay', {
        styleMap: new OpenLayers.StyleMap({
            externalGraphic: imagesPath + 'marker/green.png',
            title: '${tooltip}'
        })
    });
    var currentPopup;
    var markerClick = function (evt) {
        if (currentPopup != null && currentPopup.visible()) {
            currentPopup.hide();
        }

        if (this.popup == null) {
            this.popup = this.createPopup(this.closeBox);
            map.addPopup(this.popup);
            this.popup.show();
        } else {
            this.popup.toggle();
        }
        currentPopup = this.popup;
        OpenLayers.Event.stop(evt);
    };

    var markerMouseover = function (evt) {
        if (currentPopup != null && currentPopup.visible() && this.popup != currentPopup) {
            currentPopup.hide();
        }

        if (this.popup == null) {
            this.popup = this.createPopup(this.closeBox);
            map.addPopup(this.popup);
            this.popup.show();
        } else {
            this.popup.toggle();
        }
        currentPopup = this.popup;
        OpenLayers.Event.stop(evt);
    };

    var popupClass = OpenLayers.Class(OpenLayers.Popup.FramedCloud, {
        "autoSize": true,
        "minSize": new OpenLayers.Size(100, 50),
        "maxSize": new OpenLayers.Size(200, 300),
        "keepInMap": true
    });

    map.addLayer(markers);
    $.each(cities, function (index, city) {
        
        
        var lonlat = new OpenLayers.LonLat(city.lng, city.lat).transform(
                new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
                new OpenLayers.Projection("EPSG:900913") // to Spherical Mercator
                );
        if (cities.length < 100) {
            var icon = new OpenLayers.Icon(imagesPath + 'marker/green.png', size, offset);
        } else {
            var icon = new OpenLayers.Icon(imagesPath + 'marker/number_' + (index + 1) + '.png', size, offset);
        }


        var marker = new OpenLayers.Marker(lonlat, icon);

        var feature = new OpenLayers.Feature(marker, lonlat);
        feature.closeBox = true;
        feature.popupClass = popupClass;
        feature.data.popupContentHTML = '<b>' + city.name + '</b><br>' + city.population + '<br>' + city.link;
        feature.data.overflow = "auto";

        marker.events.register("mousedown", feature, markerClick);
        marker.events.register("mouseover", feature, markerMouseover);
        markers.addMarker(marker);

    });
    map.zoomToExtent(markers.getDataExtent());
    if (cities.length == 1) {
        map.setCenter(lonlat, 30);
    }

}
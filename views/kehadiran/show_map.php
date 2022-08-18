<?php

use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\MapTypeId;

$lat = $val[0];
$lng = $val[1];

$coord = new LatLng(['lat' => $lat, 'lng' => $lng]);

$map = new Map([
    'center' => $coord,
    'zoom' => 18,
    'mapTypeId' => MapTypeId::HYBRID,
    'width' => '100%',
    'height' => '300',
        ]);


// Lets add a marker now
$marker = new Marker([
    'position' => $coord,
    'title' => 'My Home Town',
        ]);

// Provide a shared InfoWindow to the marker
$marker->attachInfoWindow(
        new InfoWindow([
    'content' => 'Mohamad Hamizi bin Mahmood',
        ])
);

// Add marker to the map
$map->addOverlay($marker);

echo $map->display();
?>
<?php
/**
 * Created by Sebastian Viereck IT-Services
 * www.sebastianviereck.de
 * Date: 17.03.14
 * Time: 15:39
 */
namespace app\widgets\OpenLayers;

use yii\base\Widget;

use Yii;

class OpenLayers extends Widget
{
    public $cities;
    public $map_id;
    private $isTestModus = false;

    public function run()
    {
        if($this->cities){
            $this->getView()->registerJsFile("https://openlayers.org/api/OpenLayers.js");
            list($path, $webPath) =Yii::$app->getAssetManager()->publish(__DIR__."/assets/js/OpenLayers.js",['foreCopy' => $this->isTestModus]);
            $this->getView()->registerJsFile($webPath);
            list($path, $webPathImages) =Yii::$app->getAssetManager()->publish(__DIR__."/assets/images",['foreCopy' => $this->isTestModus]);
            $this->getView()->registerJs(
                "
                    var imagesPath = '".$webPathImages."/' ;
                    var cities = ". json_encode($this->cities).";
                    var center = ". json_encode($this->getCenterFromCities($this->cities)).";
                    var map_id = ".  json_encode($this->map_id).";
                    initOpenLayer(cities, center, map_id, imagesPath);


                "
            );

            echo $this->render("cities",
                array(
                    "map_id" => $this->map_id,
                )
            );
        }
        else
        {
            throw new \Exception("no cities for map");
        }

    }


    private function getCenterFromCities($cities){
        if ($cities)
        {
            foreach($cities as $city){
                $lng = $city['lng'];
                $lat = $city['lat'];
                if($lng && $lat){
                    $allLat[] = $lat;
                    $allLng[] = $lng;
                }
            }
            $maxLat = max($allLat);
            $minLat = min($allLat);
            $centerLat = $maxLat - ($maxLat - $minLat)/2;

            $maxLng = max($allLng);
            $minLng = min($allLng);
            $centerLng = $maxLng - ($maxLng - $minLng)/2;
            return array("lat" => $centerLat, "lng" => $centerLng);
        }
    }

}
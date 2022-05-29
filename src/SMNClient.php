<?php

namespace Principal;

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class SMNClient{

    public function start(){

        $url = "https://smn.conagua.gob.mx/tools/PHP/Imagen_Satelite_Ultimas.php?satelite=GOES%20Este&nombre=M%E9xico&tipo=Tope%20de%20Nubes";
        $headers = [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ];
        $body = "";

        $client = new Client();
        $request = new Request('GET', $url, $headers, $body);
        
        $response = $client->send($request, [
            'verify' => false,
        ]);

        $imageId = $response->getBody()->getContents();

        $index = strpos($imageId, "MEDIA%2F") + 8;
        $imageId = substr($imageId, $index, 16);
        echo $imageId;
        echo "\n";

        $year = "";
        $month = "";
        $day = "";
        //$date = new DateTime();
        $formated = date('Y/F/d');
        $pathImages = "./img/$formated";

        if (!file_exists($pathImages)) {
            mkdir($pathImages, 0777, true);
        }

        # Antes de descargar la foto, saber si ya existe
        if( file_exists( "$pathImages/$imageId" ) ){
            echo "Misma imagen, no se descargará \n";
            return;
        };
       

        //Sigue obtener la imagen y guardarla.
        $imageUrl = "https://smn.conagua.gob.mx/tools/RESOURCES/GOES/GOES Este/México/Tope de Nubes/MEDIA/{$imageId}";
        $client->request('GET', $imageUrl, ['sink' => "$pathImages/{$imageId}", 'verify' => false]);
        echo "Imagen guardada\n";
    }

}
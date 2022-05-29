<?php

namespace Principal;

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

        # Antes de descargar la foto, saber si ya existe
        $filename = "./img/{$imageId}";
        if( file_exists($filename) ){
            echo "Misma imagen, no se descargará \n";
            return;
        };

        //Sigue obtener la imagen y guardarla.
        $imageUrl = "https://smn.conagua.gob.mx/tools/RESOURCES/GOES/GOES Este/México/Tope de Nubes/MEDIA/{$imageId}";
        $client->request('GET', $imageUrl, ['sink' => "./img/{$imageId}", 'verify' => false]);
        echo "Imagen guardada\n";
    }

}
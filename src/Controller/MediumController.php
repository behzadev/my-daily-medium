<?php

namespace App\Controller;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MediumController extends AbstractController
{
    /**
     * @Route("/queue", methods={"GET"}, name="medium")
     */
    public function index(Request $request)
    {
        $articleURL = $request->query->get('article');

        $headers = ['Referer' => 'twitter.com'];
        
        $client = new Client(['headers' => $headers]);

        $res = $client->request('GET', $articleURL . '?format=json');
        
        $body = str_replace('])}while(1);</x>','',$res->getBody());

        $articleDetails = json_decode($body)->payload->value;

        dd($articleDetails);
        
        // TODO
    }
}

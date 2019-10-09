<?php

namespace App\Controller;

use GuzzleHttp\Client;
use App\Service\Medium\MediumParser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MediumController extends AbstractController
{
    /**
     * @Route("/queue", methods={"GET"}, name="medium")
     */
    public function index(Request $request): JsonResponse
    {
        $articleURL = $request->query->get('article');

        $headers = ['Referer' => 'twitter.com'];
        
        $client = new Client(['headers' => $headers]);

        $response = $client->request('GET', $articleURL . '?format=json');
        
        $pageBody = str_replace('])}while(1);</x>', '', $response->getBody());

        $articleDetails = MediumParser::parse($pageBody);

        if ($request->query->get('dump')) {
            dd($articleDetails);
        }

        return new JsonResponse(
            // TODO
        );
    }
}

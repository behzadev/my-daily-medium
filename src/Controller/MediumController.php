<?php

namespace App\Controller;

use App\Service\Medium;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MediumController extends AbstractController
{
    /**
     * @Route("/queue", methods={"GET"}, name="medium")
     */
    public function index(Request $request, Medium $medium): JsonResponse
    {
        $articleURL = $request->query->get('article');
        
        $article = $medium->getArticle($articleURL);

        $articleDetails = $medium->parse($article);

        if ($request->query->get('dump')) {
            dd($articleDetails);
        }

        return new JsonResponse(
            // TODO
        );
    }
}

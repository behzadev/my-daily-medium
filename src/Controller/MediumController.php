<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\Medium;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MediumController extends AbstractController
{
    /**
     * @Route("/queue", methods={"GET"}, name="medium")
     */
    public function index(Request $request, Medium $medium, EntityManagerInterface $entityManager): JsonResponse
    {
        $articleURL = $request->query->get('article');
        
        $article = $medium->getArticle($articleURL);

        $articleDetails = $medium->parse($article);

        if ($request->query->get('dump')) {
            dd($articleDetails);
        }

        $article = new Article;
        $article
            ->setTitle($articleDetails['title'])
            ->setText($articleDetails['text'])
            ->setImage($articleDetails['image'])
            ->setCharsCount($articleDetails['chars_count'])
            ->setParagraphsCount($articleDetails['paragraphs_count']);

        $entityManager->persist($article);

        $entityManager->flush();
    
        return new JsonResponse([
            'success' => true
        ]);
    }
}

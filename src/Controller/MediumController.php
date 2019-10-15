<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\Medium;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MediumController extends AbstractController
{
    /**
     * @Route("/queue", methods={"GET"}, name="medium_queue_create")
     */
    public function create(Request $request, Medium $medium): Response
    {
        $articleURL = $request->query->get('article');
        
        $article = $medium->getArticle($articleURL);

        $articleDetails = $medium->parse($article);

        return $this->render('queue/index.html.twig', [
            'article' => $articleDetails
        ]);
    }

    /**
     * @Route("/queue", methods={"POST"}, name="medium_queue_store")
     */
    public function store(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $article = new Article;
        $article
            ->setTitle($request->get('title'))
            ->setText($request->get('text'))
            ->setImage($request->get('image'))
            ->setCharsCount(Medium::getCharsCount($request->get('text')))
            ->setParagraphsCount(Medium::getParagraphsCount($request->get('text')));

        $entityManager->persist($article);

        $entityManager->flush();
    
        return new JsonResponse([
            'status' => 'success'
        ]);
    }
}

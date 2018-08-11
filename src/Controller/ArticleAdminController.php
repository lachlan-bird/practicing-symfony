<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article/new", name="article_admin")
     */
    public function new(EntityManagerInterface $entityManager)
    {


        return new Response("Article {$article->getId()} created with slug {$article->getSlug()}");

    }
}

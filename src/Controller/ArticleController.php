<?php

namespace App\Controller;


use App\Entity\Article;
use App\Service\SlackClient;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    private $isDebug;
    private $slack;

    public function __construct(bool $isDebug)
    {

        $this->isDebug = $isDebug;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('article/homepage.html.twig');
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show($slug, SlackClient $slackClient, EntityManagerInterface $em)
    {
        if($slug == 'slack') {
            $slackClient->sendMessage('Lachlan', 'Hi!');
        }

        $repository = $em->getRepository(Article::class);

        $article = $repository->findOneBy([
            'slug' => $slug
        ]);

        if(!$article) {
            throw $this->createNotFoundException("No article found for slug {$slug}");
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'comments' => [
                'I hate this site!',
                'This is dumb',
                'Working on learning Symfony!'
            ]
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"post"})
     */
    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        $logger->info('Article is being hearted');

        return $this->json([
            'hearts' => rand(5, 100)
        ]);
    }
}
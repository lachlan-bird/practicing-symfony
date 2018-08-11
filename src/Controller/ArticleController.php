<?php

namespace App\Controller;


use App\Service\MarkdownHelper;
use Nexy\Slack\Client;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    private $isDebug;
    private $slack;

    public function __construct(bool $isDebug, Client $slack)
    {

        $this->isDebug = $isDebug;
        $this->slack = $slack;
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
    public function show($slug, MarkdownHelper $markdownHelper)
    {
        if($slug == 'slack') {
            $message = $this->slack->createMessage()
                ->from('John Doe')
                ->withIcon(':ghost:')
                ->setText('This is an amazing message!');

            $this->slack->sendMessage($message);
        }
        $articleContent = <<<EOF
Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow,
lorem proident [beef ribs](https://baconipsum.com) aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit
labore minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow
**turkey** shank eu pork belly meatball non cupim.

Laboris beef ribs fatback fugiat eiusmod jowl kielbasa alcatra dolore velit ea ball tip. Pariatur
laboris sunt venison, et laborum dolore minim non meatball. Shankle eu flank aliqua shoulder,
capicola biltong frankfurter boudin cupim officia. Exercitation fugiat consectetur ham. Adipisicing
picanha shank et filet mignon pork belly ut ullamco. Irure velit turducken ground round doner incididunt
occaecat lorem meatball prosciutto quis strip steak.

Meatball adipisicing ribeye bacon strip steak eu. Consectetur ham hock pork hamburger enim strip steak
mollit quis officia meatloaf tri-tip swine. Cow ut reprehenderit, buffalo incididunt in filet mignon
strip steak pork belly aliquip capicola officia. Labore deserunt esse chicken lorem shoulder tail consectetur
cow est ribeye adipisicing. Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck
fugiat.
EOF;

        return $this->render('article/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'articleContent' => $markdownHelper->parseAndCache($articleContent),
            'comments' => [
                'I hate this site!',
                'This is dumb',
                'Working on learning Symfony!'
            ],
            'slug' => $slug
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
<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CommentFixture extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Comment::class, 100, function(Comment $comment) {
            $comment->setContent(
                $this->faker->boolean ? $this->faker->paragraph : $this->faker->sentences(2, true)
            )->setAuthorName($this->faker->name);

            $comment->setCreatedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'));

            $comment->setArticle($this->getRandomReference(Article::class));

        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [ArticleFixture::class];
    }
}

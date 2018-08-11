<?php
/**
 * Created by PhpStorm.
 * User: lachlan
 * Date: 11/8/18
 * Time: 9:30 PM
 */

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

abstract class BaseFixture extends Fixture
{
    /** @var ObjectManager */
    private $manager;

    abstract protected function loadData(ObjectManager $em);

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->loadData($manager);
    }

    protected function createMany(string $className, int $count, callable $factory)
    {
        for($i = 0; $i < $count; $i++)
        {
            $entity = new $className();
            $factory($entity, $i);

            $this->manager->persist($entity);

            $this->addReference($className . '_' . $i, $entity);
        }
    }
}
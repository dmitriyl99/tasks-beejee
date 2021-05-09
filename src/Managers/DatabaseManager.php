<?php


namespace Managers;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;


class DatabaseManager
{
    static protected $initialized = false;

    /** @var EntityManager */
    static private $entityManager;

    public static function init(EntityManagerInterface $entityManager)
    {
        if (self::$initialized)
            return;
        self::$entityManager = $entityManager;
        self::$initialized = true;
    }

    protected function getRepository(string $entity)
    {
        return self::$entityManager->getRepository($entity);
    }

    protected function createEntity($entity)
    {
        self::$entityManager->persist($entity);
        self::$entityManager->flush();
    }

    protected function flush($entity = null)
    {
        self::$entityManager->flush($entity);
    }
}
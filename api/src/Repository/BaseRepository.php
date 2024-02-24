<?php

declare(strict_types=1);

namespace App\Repository;

//use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;

abstract class BaseRepository
{
    private ManagerRegistry $managerRegistry;
    protected Connection $connection;
    protected ObjectRepository $objectRepository;

    public function __construct(ManagerRegistry $managerRegistry, Connection $connection)
    {
        $this->managerRegistry = $managerRegistry;
        $this->connection = $connection;
        $this->objectRepository = $this->getEntityManager()->getRepository($this->entityClass());
    }

    abstract protected static function entityClass(): string;


    /**
     * @throws \Doctrine\ORM\ORMException;
     */
    public function persistEntity(object $entity): void
    {
        $this->getEntityManager()->persist($entity);  
    }


    /**
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws MappingException
     */
    public function flushData(): void
    {
        $this->getEntityManager()->flush();
        $this->getEntityManager()->clear();
    }


    /**
     * @param object $entity
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     * */
    public function saveEntity(object $entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }


    /**
     * @param object $entity
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function removeEntity(object $entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }


    /**
     * @param string $query
     * @param array $params
     * @return array
     * @throws DBALException
     */
    protected function executeFetchQuery(string $query, array $params = []): array
    {
        return $this->connection->executeQuery($query, $params)->fetchAll();
    }


    /**
     * @param string $query
     * @param array $params
     * @return void
     * @throws DBALException
     */
    protected function executeQuery(string $query, array $params = []): void
    {
        $this->connection->executeQuery($query, $params);
    }


    /**
     * @return EntityManager
     */
    private function getEntityManager(): EntityManager
    {
        $entityManager = $this->managerRegistry->getManager();

        // Verificar si el Entity Manager está abierto
        if ($entityManager instanceof EntityManager && $entityManager->isOpen()) {
            return $entityManager;     
        }

        return $this->managerRegistry->resetManager();
    }
    
}
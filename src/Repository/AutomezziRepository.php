<?php

namespace App\Repository;

use App\Entity\Automezzi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Automezzi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Automezzi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Automezzi[]    findAll()
 * @method Automezzi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AutomezziRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Automezzi::class);
    }

    private function createPaginator(Query $query, int $page): Pagerfanta
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
        $paginator->setMaxPerPage(10);
        $paginator->setCurrentPage($page);

        return $paginator;
    }

    public function findAllPaginator(int $page = 1): Pagerfanta
    {
        $qb = $this->createQueryBuilder('a');

        return $this->createPaginator($qb->getQuery(), $page);
    }

    public function findScadenze()
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select($qb->expr()->min('a.dataBollo'))
            ->addSelect($qb->expr()->min('a.dataRevisione'))
            ->where('a.dismesso = false')
            ->orderBy('a.modello');

        return $qb->getQuery()->getArrayResult();
    }

    // /**
    //  * @return Users[] Returns an array of Users objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Users
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

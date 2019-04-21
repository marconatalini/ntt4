<?php

namespace App\Repository;

use App\Entity\Clienti;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Clienti|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clienti|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clienti[]    findAll()
 * @method Clienti[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientiRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Clienti::class);
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
        $qb = $this->createQueryBuilder('c');

        return $this->createPaginator($qb->getQuery(), $page);
    }


    public function findFilteredPaginator(int $page = 1, $search): Pagerfanta
    {
        $qb = $this->createQueryBuilder('c');

        if ($search['codice'] !== "" ){
            $qb->andWhere('c.codice like :val')
                ->setParameter('val', $search['codice'])
            ;
        }

        if ($search['ragioneSociale'] !== ""){
            $qb->andWhere('c.ragioneSociale like :cliente')
                ->setParameter('cliente', '%'.$search['ragioneSociale'].'%')
            ;
        }

        if ($search['email'] !== ""){
            $qb->andWhere('c.email like :mail')
                ->setParameter('mail', '%'.$search['email'].'%')
            ;
        }

        return $this->createPaginator($qb->getQuery(), $page);
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

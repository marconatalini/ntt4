<?php

namespace App\Repository;

use App\Entity\Fatture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Fatture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fatture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fatture[]    findAll()
 * @method Fatture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FattureRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Fatture::class);
    }

    private function createPaginator(Query $query, int $page, int $maxPage = 100): Pagerfanta
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
        $paginator->setMaxPerPage($maxPage);
        $paginator->setCurrentPage($page);

        return $paginator;
    }

    public function findAllPaginator(int $page = 1): Pagerfanta
    {
        $qb = $this->createQueryBuilder('d');

        return $this->createPaginator($qb->getQuery(), $page);
    }

    public function findLastsPaginator(int $page = 1): Pagerfanta
    {
        $qb = $this->createQueryBuilder('f')
            ->where('f.dataFattura >= :dataval')
            ->orderBy('f.id', 'DESC')
            ->setParameter('dataval', strtotime('-2 month'))
        ;

        return $this->createPaginator($qb->getQuery(), $page);
    }

    public function findFilteredPaginator(int $page = 1, $search): Pagerfanta
    {
        $qb = $this->createQueryBuilder('d');

        if ($search['anno'] !== "" ){
            $qb->andWhere('d.dataFattura like :data')
                ->setParameter('data', $search['anno'].'-'.$search['mese'].'%')
            ;
        }

        if ($search['codice'] !== "" ){
            $qb->andWhere('d.cliente = :cliente')
                ->setParameter('cliente', $search['codice'])
            ;
        }


        if ($search['sortBy'] !== ""){
            if ($search['order'] !== "") {
                $qb->orderBy('d.'.$search['sortBy'], $search['order']);
            } else {
                $qb->orderBy('d.'.$search['sortBy'], 'ASC');
            }
        }

        return $this->createPaginator($qb->getQuery(), $page);
    }

    public function findAnnoMese($anno, $mese){

        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

        $qb = $this->createQueryBuilder('f');
        $qb->where('YEAR(f.dataFattura) = :year')
            ->andWhere('MONTH(f.dataFattura) = :mese')
            ->setParameter('year', $anno)
            ->setParameter('mese', $mese);

        $qb->orderBy('f.numeroFattura','ASC');

        return $qb->getQuery()->getResult();
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

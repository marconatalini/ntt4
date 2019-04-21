<?php

namespace App\Repository;

use App\Entity\Ddts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\RegistryInterface;
use DoctrineExtensions\Query\Mysql;

/**
 * @method Ddts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ddts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ddts[]    findAll()
 * @method Ddts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DdtsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ddts::class);
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
        $qb = $this->createQueryBuilder('d');

        return $this->createPaginator($qb->getQuery(), $page);
    }

    public function findLastsPaginator(int $page = 1): Pagerfanta
    {
        $qb = $this->createQueryBuilder('d')
            ->where('d.dataDdt >= :dataval')
            ->orderBy('d.id', 'DESC')
            ->setParameter('dataval', strtotime('-2 month'))
        ;

        return $this->createPaginator($qb->getQuery(), $page);
    }

    public function findFilteredPaginator(int $page = 1, $search): Pagerfanta
    {
        $qb = $this->createQueryBuilder('d');

        if ($search['data'] !== "" ){
            $qb->andWhere('d.dataDdt >= :data')
                ->setParameter('data', $search['data'])
            ;
        }

        if ($search['numero'] !== "" ){
            $qb->andWhere('d.numeroDdt = :numero')
                ->setParameter('numero', $search['numero'])
            ;
        }

        if ($search['cliente'] !== ""){
            $qb->andWhere('d.cliente = :cliente')
                ->setParameter('cliente', $search['cliente'])
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

    public function findDdtFatturabili($page, $idcli, $data_ft) : Pagerfanta
    {
        $qb = $this->createQueryBuilder('ddt');
        $qb->join('ddt.cliente', 'c', 'with', $qb->expr()->eq('c.id', ':cliente'))
            ->where($qb->expr()->andX(
                $qb->expr()->lte('ddt.dataDdt', ':dataFt'),
                $qb->expr()->isNull('ddt.fattura'),
                $qb->expr()->eq('c.id',':cliente')))
            ->setParameter('dataFt', $data_ft)
            ->setParameter('cliente', $idcli)
            ->orderBy('ddt.dataDdt','ASC');

        return $this->createPaginator($qb->getQuery(), $page);
    }

    public function findDtdAutomezzo($page, $id, $anno, $mese) : Pagerfanta{

        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

        $qb = $this->createQueryBuilder('d');
        $qb->join('d.automezzo', 'a', 'with', $qb->expr()->eq('a.id', ':automezzo'))
            ->where('YEAR(d.dataDdt) = :year')
            ->setParameter('year', $anno)
            ->setParameter('automezzo', $id);

        if ("" != $mese) {
            $qb->andWhere('MONTH(d.dataDdt) = :mese')
                ->setParameter('mese', $mese);
        }

        $qb->orderBy('d.dataDdt','ASC');

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

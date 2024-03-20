<?php

namespace App\Repository;

use App\Entity\Inscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Inscription>
 *
 * @method Inscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inscription[]    findAll()
 * @method Inscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inscription::class);
    }

    public function listeInscription($idSession) 
	{

        $queryBuilder = $this->createQueryBuilder('i')
            ->join('i.sessionformation', 's')
            ->andWhere(':idSession = s.id')
		    ->setParameter('idSession', $idSession);
        
        $query = $queryBuilder->getQuery();

        // On gère ensuite la pagination grace au service KNPaginator
        return $query->getResult();
	}

    public function suppInscription($idSession) 
	{
        $qb = $this->createQueryBuilder('i');
		$query = $qb->delete('App\Entity\Inscription', 's')
		  ->where('i.sessionformation_id = :idSession')
		  ->setParameter('idSession', $idSession);
		
		return $qb->getQuery()->getResult();
	}

//    /**
//     * @return Inscription[] Returns an array of Inscription objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Inscription
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

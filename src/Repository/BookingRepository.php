<?php

namespace App\Repository;

use App\Entity\Booking;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    /**
     * check si la chambre est libre aux dates données.
     *
     * @param Booking
     * 
     * @return bool
     */
    public function checkDispo(Booking $booking)
    {
        $st = $booking->getStartDate()->format('Y-m-d');
        $ed = $booking->getEndDate()->format('Y-m-d');
        $qb= $this->createQueryBuilder('b');
        $qb = $qb
                ->innerJoin('b.room', 'r')
                ->andWhere('r.id = :roomId')
                ->setParameter('roomId', $booking->getRoom()->getId())
                // ->andWhere("(b.startDate BETWEEN :std AND :edd or b.endDate BETWEEN :std AND :edd)")
                ->andWhere(
                    $qb->expr()->orX(
                        $qb->expr()->between('b.startDate', ":std", ":edd"),
                        $qb->expr()->between('b.endDate', ":std", ":edd")
                    )
                )
                ->setParameter('std', $st)
                ->setParameter('edd', $ed)
        ;

        $result = $qb->getQuery()->getResult();

        // $sql ='SELECT * FROM `booking` WHERE room_id = :roomId and ((:std >= start_date and :std <= end_date) > 0 OR (:edd >= start_date and :edd <= end_date) > 0)';
        // $stmt  = $this->_em->getConnection()->prepare($sql);
        // $stmt->execute([
        //     'roomId' => $booking->getRoom()->getId(),
        //     'std'=> $booking->getStartDate()->format('Y-m-d H:i:s'),
        //     'edd'=> $booking->getEndDate()->format('Y-m-d H:i:s'),
        // ]);
      
        // // $result = $qb->getQuery()->getResult();
      
        // return $stmt->fetchAll();

        return count($result) == 0;
    }

    /**
     * getBookingsByRoom
     *
     * @param int $idRoom
     * 
     * @return Booking[]
     */
    public function getBookingsByRoom($idRoom)
    {
        $qb = $this->createQueryBuilder('b');

        $bookings = $qb
                    ->join('b.room', 'r')
                    ->andWhere('r.id = :idRoom')
                    ->setParameter('idRoom', $idRoom)
                    ->andWhere(
                        $qb->expr()->orX(
                            $qb->expr()->andX('b.startDate >= :today'),
                            $qb->expr()->andX('b.endDate >= :today')
                        )
                    )
                    ->setParameter('today', new DateTime())
                    ->addOrderBy('b.startDate','Asc')
                    ->getQuery()
                    ->getResult()
        ;

        return $bookings;
    }

    // /**
    //  * @return Booking[] Returns an array of Booking objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Booking
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

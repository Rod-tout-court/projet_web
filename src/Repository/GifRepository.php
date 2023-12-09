<?php

namespace App\Repository;

use App\Entity\Gif;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Gif>
 *
 * @method Gif|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gif|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gif[]    findAll()
 * @method Gif[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GifRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gif::class);
    }

    public function findByTags(array $tags): array {
        $gif_array = [];
        dump($tags);
        // On recherche les gif qui contienne l'un des tags
        foreach($tags as $tag ){
            $gifs = $this->createQueryBuilder('g')
            ->where('g.tags LIKE :val')
            ->setParameter('val', '%'.$tag.'%')
            ->getQuery()
            ->getResult();
        foreach($gifs as $gif) {
            array_push($gif_array, $gif);
        }
        }

        return $gif_array;
    }

//    /**
//     * @return Gif[] Returns an array of Gif objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Gif
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

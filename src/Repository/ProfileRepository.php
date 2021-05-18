<?php

namespace App\Repository;

use App\Entity\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Profile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profile[]    findAll()
 * @method Profile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileRepository extends ServiceEntityRepository
{
    private $manager;
    public function __construct(ManagerRegistry $registry,  EntityManagerInterface $manager)
    {
        parent::__construct($registry, Profile::class);
        $this->manager = $manager;
    }

    public function addNewProfile($fullname,$mobile, $email, $gender, $birthdate){
        $p = new Profile();
        $p->setFullname($fullname);
        $p->setMobile($mobile);
        $p->setEmail($email);
        $p->setGender($gender);
        $p->setBirthdate($birthdate);
        $p->setAge($this->computeAge($birthdate));
        $this->manager->persist($p);
        $this->manager->flush();

    }
    private function computeAge($birthdate): ?int
    {

        $birthDate = explode("-", $birthdate);

    return (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md") ? ((date("Y")-$birthDate[0])):(date("Y")-$birthDate[0]));
    }

    // /**
    //  * @return Profile[] Returns an array of Profile objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Profile
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

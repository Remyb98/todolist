<?php

namespace App\Repository;

use App\Data\TaskState;
use App\Entity\Task;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Task>
 *
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    const int ITEM_PER_PAGE = 10;

    public function __construct(
        private readonly PaginatorInterface $paginator,
        ManagerRegistry                     $registry
    )
    {
        parent::__construct($registry, Task::class);
    }

    public function findAllPagination(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->createQueryBuilder('t')
                ->leftJoin('t.assignee', 'assignee')
                ->leftJoin('t.createdBy', 'createdBy')
                ->leftJoin('t.updatedBy', 'updatedBy')
                ->select('t', 'assignee', 'createdBy', 'updatedBy')
                ->orderBy('t.id', 'ASC'),
            $page,
            self::ITEM_PER_PAGE,
            [
                'distinct' => false
            ]
        );
    }

    public function findLateTasksByUser(User $user): mixed
    {
        return $this->createQueryBuilder('t')
            ->where('t.assignee = :user')
            ->setParameter('user', $user)
            ->andWhere('t.state = :state')
            ->setParameter('state', TaskState::PENDING)
            ->andWhere('t.dueDate < :date')
            ->setParameter('date', new DateTime())
            ->getQuery()
            ->getResult();
    }

    public function findComingTasksByUser(User $user): mixed
    {
        return $this->createQueryBuilder('t')
            ->where('t.assignee = :user')
            ->setParameter('user', $user)
            ->andWhere('t.state = :state')
            ->setParameter('state', TaskState::PENDING)
            ->andWhere('t.dueDate >= :date')
            ->setParameter('date', new DateTime())
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Task[] Returns an array of Task objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Task
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

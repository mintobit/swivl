<?php
declare(strict_types=1);

namespace SwivlClassroomBundle\Repository;

use Doctrine\ORM\EntityRepository;
use SwivlClassroomBundle\Entity\Classroom;
use SwivlClassroomBundle\Service\ClassroomManagerInterface;

class ClassroomRepository extends EntityRepository implements ClassroomManagerInterface
{
    public function getAll(): array
    {
        return $this->findAll();
    }

    public function findById(int $id)
    {
        return $this->find($id);
    }

    public function save(Classroom $classroom)
    {
        $this->getEntityManager()->persist($classroom);
        $this->getEntityManager()->flush($classroom);
    }

    public function delete(Classroom $classroom)
    {
        $this->getEntityManager()->remove($classroom);
        $this->getEntityManager()->flush($classroom);
    }
}

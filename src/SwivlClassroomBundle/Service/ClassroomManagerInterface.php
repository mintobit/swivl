<?php
declare(strict_types=1);

namespace SwivlClassroomBundle\Service;

use SwivlClassroomBundle\Entity\Classroom;

interface ClassroomManagerInterface
{
    /**
     * @return Classroom[]
     */
    public function getAll(): array;

    /**
     * @param int $id
     *
     * @return Classroom|null
     */
    public function findById(int $id);

    /**
     * @param Classroom $classroom
     *
     * @return void
     */
    public function save(Classroom $classroom);

    /**
     * @param Classroom $classroom
     *
     * @return void
     */
    public function delete(Classroom $classroom);
}
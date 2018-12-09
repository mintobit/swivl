<?php
declare(strict_types=1);

namespace SwivlClassroomBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use SwivlClassroomBundle\Entity\Classroom;
use SwivlClassroomBundle\Form\ClassroomType;
use SwivlClassroomBundle\Service\ClassroomManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClassroomController extends FOSRestController
{
    const MESSAGE_NO_CLASSROOMS         = 'No classrooms exist';
    const MESSAGE_CLASSROOM_NOT_FOUND   = 'Classroom not found';
    const MESSAGE_CLASSROOM_DELETED     = 'Classroom deleted';

    /**
     * @Rest\Get("/classroom")
     */
    public function classroomAction()
    {
        /** @var ClassroomManagerInterface $classroomManager */
        $classroomManager = $this->get('classroom_manager');
        $classrooms = $classroomManager->getAll();
        if (empty($classrooms)) {
            return $this->view(static::MESSAGE_NO_CLASSROOMS, Response::HTTP_NO_CONTENT);
        }

        return $classrooms;
    }

    /**
     * @Rest\Get("/classroom/{id}")
     */
    public function getClassroomAction($id)
    {
        /** @var ClassroomManagerInterface $classroomManager */
        $classroomManager = $this->get('classroom_manager');
        $classroom = $classroomManager->findById((int) $id);
        if (null === $classroom) {
            return $this->view(static::MESSAGE_CLASSROOM_NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        return $classroom;
    }

    /**
     * @Rest\Post("/classroom")
     */
    public function createClassroomAction(Request $request)
    {
        /** @var ClassroomManagerInterface $classroomManager */
        $classroomManager = $this->get('classroom_manager');
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $classroomManager->save($classroom);

            return $classroom;
        }

        return $form;
    }

    /**
     * @Rest\Put("/classroom/{id}")
     */
    public function updateClassroomAction($id, Request $request)
    {
        /** @var ClassroomManagerInterface $classroomManager */
        $classroomManager = $this->get('classroom_manager');
        $classroom = $classroomManager->findById((int) $id);
        if (null === $classroom) {
            return $this->view(static::MESSAGE_CLASSROOM_NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(ClassroomType::class, $classroom, ['method' => 'PUT']);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $classroomManager->save($classroom);

            return $classroom;
        }

        return $form;
    }

    /**
     * @Rest\Patch("/classroom/{id}")
     */
    public function patchClassroomAction($id, Request $request)
    {
        /** @var ClassroomManagerInterface $classroomManager */
        $classroomManager = $this->get('classroom_manager');
        $classroom = $classroomManager->findById((int) $id);
        if (null === $classroom) {
            return $this->view(static::MESSAGE_CLASSROOM_NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(ClassroomType::class, $classroom, ['method' => 'PATCH']);
        $form->submit($request->request->all(), false);

        if ($form->isValid()) {
            $classroomManager->save($classroom);

            return $classroom;
        }

        return $form;
    }

    /**
     * @Rest\Delete("/classroom/{id}")
     */
    public function deleteClassroomAction($id)
    {
        /** @var ClassroomManagerInterface $classroomManager */
        $classroomManager = $this->get('classroom_manager');
        $classroom = $classroomManager->findById((int) $id);
        if (null === $classroom) {
            return $this->view(static::MESSAGE_CLASSROOM_NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        $classroomManager->delete($classroom);

        return $this->view(static::MESSAGE_CLASSROOM_DELETED);
    }
}

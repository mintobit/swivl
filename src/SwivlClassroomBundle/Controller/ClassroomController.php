<?php

namespace SwivlClassroomBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use SwivlClassroomBundle\Entity\Classroom;
use SwivlClassroomBundle\Form\ClassroomType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClassroomController extends FOSRestController
{
    /**
     * @Rest\Get("/classroom")
     */
    public function classroomAction()
    {
        $classroomRepository = $this->get('repository.classroom');
        $classrooms = $classroomRepository->findAll();
        if (empty($classrooms)) {
            return new View('No classrooms exist', Response::HTTP_NOT_FOUND);
        }

        return $classrooms;
    }

    /**
     * @Rest\Get("/classroom/{id}")
     */
    public function getClassroomAction($id)
    {
        $classroomRepository = $this->get('repository.classroom');
        $classroom = $classroomRepository->find($id);
        if (null === $classroom) {
            //return new View('Classroom not found', Response::HTTP_NOT_FOUND);
            throw $this->createNotFoundException('Classroom not found');
        }

        return $classroom;
    }

    /**
     * @Rest\Post("/classroom")
     */
    public function createClassroomAction(Request $request)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em->persist($classroom);
            $em->flush();

            return $classroom;
        }

        return $form;
    }

    /**
     * @Rest\Put("/classroom/{id}")
     */
    public function updateClassroomAction($id, Request $request)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $classroomRepository = $this->get('repository.classroom');
        $classroom = $classroomRepository->find($id);
        if (null === $classroom) {
            return new View('Classroom not found', Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(ClassroomType::class, $classroom, ['method' => 'PUT']);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em->flush();

            return $classroom;
        }

        return $form;
    }

    /**
     * @Rest\Patch("/classroom/{id}")
     */
    public function patchClassroomAction($id, Request $request)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $classroomRepository = $this->get('repository.classroom');
        $classroom = $classroomRepository->find($id);
        if (null === $classroom) {
            return new View('Classroom not found', Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(ClassroomType::class, $classroom, ['method' => 'PATCH']);
        $form->submit($request->request->all(), false);

        if ($form->isValid()) {
            $em->flush();

            return $classroom;
        }

        return $form;
    }

    /**
     * @Rest\Delete("/classroom/{id}")
     */
    public function deleteClassroomAction($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $classroomRepository = $this->get('repository.classroom');
        $classroom = $classroomRepository->find($id);
        if (null === $classroom) {
            return new View('Classroom not found', Response::HTTP_NOT_FOUND);
        }

        $em->remove($classroom);
        $em->flush();

        return $this->view('Classroom deleted');
    }
}

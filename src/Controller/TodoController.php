<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Repository\TodoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TodoController extends AbstractController
{
    /**
     * @Route("/api/todos", name="get_todos", methods={"GET"})
     */
    public function getTodos(TodoRepository $todoRepository, SerializerInterface $serializer): JsonResponse
    {
        $todos = $todoRepository->findAll();
        $data = $serializer->serialize($todos, 'json');

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/todos", name="create_todo", methods={"POST"})
     */
    public function createTodo(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $todo = $serializer->deserialize($request->getContent(), Todo::class, 'json');
        $todo->setCreatedAt(new \DateTime());
        $todo->setUpdatedAt(new \DateTime());

        $entityManager->persist($todo);
        $entityManager->flush();

        return new JsonResponse('Todo created', Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/todos/{id}", name="get_todo", methods={"GET"})
     */
    public function getTodo(Todo $todo, SerializerInterface $serializer): JsonResponse
    {
        $data = $serializer->serialize($todo, 'json');

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/todos/{id}", name="update_todo", methods={"PUT"})
     */
    public function updateTodo(Request $request, Todo $todo, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        // Deserialize request data into a new instance of Todo
        $updatedTodo = $serializer->deserialize($request->getContent(), Todo::class, 'json');

        // Validate if the ID from the URL matches the ID in the deserialized object
        if ($updatedTodo->getId() !== $todo->getId()) {
            throw new BadRequestHttpException('The ID in the URL does not match the ID in the request body');
        }

        // Update the existing entity with data from $updatedTodo
        $todo->setTitle($updatedTodo->getTitle());
        $todo->setDescription($updatedTodo->getDescription());
        $todo->setStatus($updatedTodo->getStatus());
        $todo->setUpdatedAt(new \DateTime());

        // Persist changes to the database
        $entityManager->flush();

        return new JsonResponse('Todo updated', Response::HTTP_OK);
    }

    /**
     * @Route("/api/todos/{id}", name="delete_todo", methods={"DELETE"})
     */
    public function deleteTodo(Todo $todo, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($todo);
        $entityManager->flush();

        return new JsonResponse('Todo deleted', Response::HTTP_OK);
    }
}

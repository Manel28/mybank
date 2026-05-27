<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/categories')]
class CategoryController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(CategoryRepository $repo): JsonResponse
    {
        return $this->json(array_map(fn(Category $category) => [
            'id' => $category->getId(),
            'title' => $category->getTitle(),
        ], $repo->findBy([], ['title' => 'ASC'])));
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $category = new Category();
        $category->setTitle($data['title']);

        $em->persist($category);
        $em->flush();

        return $this->json(['message' => 'Category created'], 201);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(Category $category, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $category->setTitle($data['title']);

        $em->flush();

        return $this->json(['message' => 'Category updated']);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(Category $category, EntityManagerInterface $em): JsonResponse
    {
        if ($category->getExpenses()->count() > 0) {
            return $this->json([
                'error' => 'You cannot delete a category used by expenses.'
            ], 400);
        }

        $em->remove($category);
        $em->flush();

        return $this->json(['message' => 'Category deleted']);
    }
}
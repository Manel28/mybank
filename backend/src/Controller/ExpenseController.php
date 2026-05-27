<?php

namespace App\Controller;

use App\Entity\Expense;
use App\Repository\CategoryRepository;
use App\Repository\ExpenseRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/expenses')]
class ExpenseController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(Request $request, ExpenseRepository $repo, UserRepository $userRepo): JsonResponse
    {
        $userId = $request->query->get('userId');
        $user = $userRepo->find($userId);

        if (!$user) {
            return $this->json([]);
        }

        $expenses = $repo->findBy(['user' => $user], ['date' => 'DESC']);

        return $this->json(array_map(fn (Expense $expense) => [
            'id' => $expense->getId(),
            'label' => $expense->getLabel(),
            'amount' => $expense->getAmount(),
            'date' => $expense->getDate()?->format('Y-m-d'),
            'category' => $expense->getCategory() ? [
                'id' => $expense->getCategory()->getId(),
                'title' => $expense->getCategory()->getTitle(),
            ] : null,
        ], $expenses));
    }

    #[Route('', methods: ['POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $em,
        CategoryRepository $categoryRepo,
        UserRepository $userRepo
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $category = $categoryRepo->find($data['categoryId'] ?? null);
        $user = $userRepo->find($data['userId'] ?? null);

        if (!$category || !$user) {
            return $this->json(['error' => 'Category or user not found'], 404);
        }

        $expense = new Expense();
        $expense->setLabel($data['label']);
        $expense->setAmount((float) $data['amount']);
        $expense->setDate(new \DateTime($data['date']));
        $expense->setCategory($category);
        $expense->setUser($user);

        $em->persist($expense);
        $em->flush();

        return $this->json(['message' => 'Expense created'], 201);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(
        Expense $expense,
        Request $request,
        EntityManagerInterface $em,
        CategoryRepository $categoryRepo
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $category = $categoryRepo->find($data['categoryId'] ?? null);

        if (!$category) {
            return $this->json(['error' => 'Category not found'], 404);
        }

        $expense->setLabel($data['label']);
        $expense->setAmount((float) $data['amount']);
        $expense->setDate(new \DateTime($data['date']));
        $expense->setCategory($category);

        $em->flush();

        return $this->json(['message' => 'Expense updated']);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(Expense $expense, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($expense);
        $em->flush();

        return $this->json(['message' => 'Expense deleted']);
    }
}
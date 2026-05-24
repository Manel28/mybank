<?php

namespace App\Controller;

use App\Entity\Expense;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ExpenseController extends AbstractController
{
    #[Route('/api/expenses', name: 'api_expenses_list', methods: ['GET'])]
    public function list(EntityManagerInterface $em): JsonResponse
    {
        $expenses = $em->getRepository(Expense::class)->findAll();

        $data = [];

        foreach ($expenses as $expense) {
            $data[] = [
                'id' => $expense->getId(),
                'label' => $expense->getLabel(),
                'amount' => $expense->getAmount(),
                'date' => $expense->getDate()->format('Y-m-d'),
                'category' => $expense->getCategory(),
            ];
        }

        return $this->json($data);
    }

    #[Route('/api/expenses', name: 'api_expenses_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $expense = new Expense();
        $expense->setLabel($data['label']);
        $expense->setAmount($data['amount']);
        $expense->setDate(new \DateTime($data['date']));
        $expense->setCategory($data['category']);

        $em->persist($expense);
        $em->flush();

        return $this->json([
            'id' => $expense->getId(),
            'label' => $expense->getLabel(),
            'amount' => $expense->getAmount(),
            'date' => $expense->getDate()->format('Y-m-d'),
            'category' => $expense->getCategory(),
        ], 201);
    }

    #[Route('/api/expenses/{id}', name: 'api_expenses_delete', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $em): JsonResponse
    {
        $expense = $em->getRepository(Expense::class)->find($id);

        if (!$expense) {
            return $this->json(['error' => 'Expense not found'], 404);
        }

        $em->remove($expense);
        $em->flush();

        return $this->json(['message' => 'Expense deleted'], 200);
    }
}
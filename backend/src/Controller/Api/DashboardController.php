<?php

namespace App\Controller\Api;

use App\Repository\AccountRepository;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/api/dashboard', name: 'api_dashboard', methods: ['GET'])]
    public function index(
        AccountRepository $accountRepository,
        TransactionRepository $transactionRepository
    ): JsonResponse {
        $account = $accountRepository->findOneBy([]);

        if (!$account) {
            return $this->json([
                'account' => null,
                'transactions' => [],
            ]);
        }

        $transactions = $transactionRepository->findBy(
            ['account' => $account],
            ['createdAt' => 'DESC']
        );

        return $this->json([
            'account' => [
                'id' => $account->getId(),
                'name' => $account->getName(),
                'balance' => $account->getBalance(),
            ],
            'transactions' => array_map(fn ($transaction) => [
                'id' => $transaction->getId(),
                'amount' => $transaction->getAmount(),
                'type' => $transaction->getType(),
                'createdAt' => $transaction->getCreatedAt()->format('Y-m-d H:i:s'),
            ], $transactions),
        ]);
    }
}
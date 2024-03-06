<?php

declare(strict_types=1);

namespace App\Api\Action\User;

use App\Entity\User;
use App\Service\Request\RequestService;
use App\Service\User\UserRegisterService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/v1/users/register", methods={"POST"})
 */
class Register
{
    private UserRegisterService $userRegisterService;

    public function __construct(UserRegisterService $userRegisterService)
    {
        $this->userRegisterService = $userRegisterService;
    }

    public function __invoke(Request $request): Response
    {
        try {
            $user = $this->userRegisterService->create(
                RequestService::getField($request, 'name'),
                RequestService::getField($request, 'email'),
                RequestService::getField($request, 'password')
            );

            return new JsonResponse(['message' => 'User registered successfully', 'user' => $user], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Failed to register user: ' . $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}

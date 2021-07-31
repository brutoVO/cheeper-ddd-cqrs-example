<?php

declare(strict_types=1);

namespace App\Controller\Chapter5\CheeperGetFollowersWithQueryBus;

use Cheeper\Chapter5\Application\Query\CountFollowers;
use Cheeper\Chapter5\Application\Query\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

// snippet get-followers-counter-controller
final class GetFollowersCounterController extends AbstractController
{
    public function __construct(
        private QueryBus $queryBus
    ) {
    }

    #[Route("/chapter-5/api/get-followers-counter/{authorId}", methods: ["GET"])]
    public function __invoke(string $authorId): JsonResponse
    {
        return
            $this->json(
                $this
                    ->queryBus
                    ->query(
                        CountFollowers::ofAuthor($authorId)
                    ),
            );

        /**
         * In case of errors like the author does not exist, you can:
         * A) Let your framework catch the Exceptions and automatically
         *    generate 404 o 500
         * B) Do it manually here in the Controller, using a try block
         *    and multiple catch blocks
         *
         *    try {
         *        ...
         *    } catch (AuthorDoesNotExist $e) {
         *        $jsonResponse = new JsonResponse(
         *            $e->getMessage(),
         *            Response::HTTP_NOT_FOUND
         *        );
         *    } catch (\Exception $e) {
         *        $jsonResponse = new JsonResponse(
         *            $e->getMessage(),
         *            Response::HTTP_INTERNAL_SERVER_ERROR
         *        );
         *    }
         *    ...
         *
         *    return $jsonResponse;
         */
    }
}
//end-snippet
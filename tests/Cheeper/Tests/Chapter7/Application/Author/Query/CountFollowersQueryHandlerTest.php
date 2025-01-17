<?php

declare(strict_types=1);

namespace Cheeper\Tests\Chapter7\Application\Author\Query;

use Cheeper\AllChapters\DomainModel\Author\AuthorDoesNotExist;
use Cheeper\Chapter5\Application\Author\Query\CountFollowersQueryHandler\CountFollowersResponse;
use Cheeper\Chapter7\Application\Author\Query\CountFollowersQuery;
use Cheeper\Chapter7\Application\Author\Query\CountFollowersQueryHandler;
use PHPUnit\Framework\TestCase;
use Redis;

//snippet count-followers-query-handler-test
final class CountFollowersQueryHandlerTest extends TestCase
{
    /**
     * @test
     * @Given Non Existing Author
     * @When Counting Followers
     * @Then Non Existing Author Exception Should Be Thrown
     */
    public function nonExistingAuthor(): void
    {
        $this->expectException(AuthorDoesNotExist::class);
        $this->expectExceptionMessage('Author "3409a21d-83b3-471e-a4f1-cf6748af65d2" does not exist');

        $nonExistingAuthorId = '3409a21d-83b3-471e-a4f1-cf6748af65d2';
        $queryHandler = new CountFollowersQueryHandler(
            $this->buildRedisMockReturning(false)
        );

        $queryHandler->__invoke(
            CountFollowersQuery::ofAuthor($nonExistingAuthorId)
        );
    }

    /**
     * @test
     * @Given An Existing Author With 0 Followers
     * @When Counting Followers
     * @Then Proper Result With 0 Followers Is Returned
     */
    public function existingAuthorWithZeroFollowers(): void
    {
        $authorId = '3409a21d-83b3-471e-a4f1-cf6748af65d2';
        $authorUsername = 'buenosvinos';
        $authorFollowers = 0;
        $queryHandler = new CountFollowersQueryHandler(
            $this->buildRedisMockReturning(
                [
                    'id' => $authorId,
                    'username' => $authorUsername,
                    'followers' => $authorFollowers,
                ]
            )
        );

        $expectedResponse = new CountFollowersResponse(
            authorId: $authorId,
            authorUsername: $authorUsername,
            numberOfFollowers: $authorFollowers
        );

        $actualResponse = $queryHandler->__invoke(
            CountFollowersQuery::ofAuthor($authorId)
        );

        $this->assertSame(
            $expectedResponse->authorId(),
            $actualResponse->authorId()
        );

        $this->assertSame(
            $expectedResponse->authorUsername(),
            $actualResponse->authorUsername()
        );

        $this->assertSame(
            $expectedResponse->numberOfFollowers(),
            $actualResponse->numberOfFollowers()
        );

        // In PHPUnit, there is also the chance to
        // compare the whole content of the object
        // $this->assertEquals($expectedResponse, $actualResponse);
    }

    private function buildRedisMockReturning($fakeReturn): Redis
    {
        $mock = $this->createStub(Redis::class);
        $mock->method('hGetAll')->willReturn(
            $fakeReturn
        );

        return $mock;
    }
}
//end-snippet

<?php

namespace CheeperLayered;

class AuthorNotFound extends \RuntimeException
{
}

//snippet cheep-service
class CheepService
{
    public function postCheep(string $username, string $message): Cheep
    {
        if (!$author = (new Authors())->byUsername($username)) {
            throw new AuthorNotFound($username);
        }
        
        $cheep = $author->compose($message);

        (new Cheeps())->add($cheep);

        return $cheep;
    }
}
//end-snippet

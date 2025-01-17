<?php

declare(strict_types=1);

namespace Cheeper\Chapter7\Application;

//snippet projeciton-bus
interface ProjectionBus
{
    public function project(Projection $projection): void;
}
//end-snippet

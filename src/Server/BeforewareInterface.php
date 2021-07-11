<?php

declare(strict_types=1);

namespace Psg\Http\Server;

use Psg\Http\Message\{ServerRequestInterface};

/**
 * Do something at the start, unrelated to transforming a request or response
 *
 * An example of "before outerware" would be loading configurations,
 * setting up database connections, etc.
 */
interface BeforewareInterface
{
    /** Do something unrelated to transforming a request or response */
    public function process(ServerRequestInterface $request, LayeredAppInterface $app);
}

<?php

declare(strict_types=1);

namespace Psg\Http\Server;

use Psg\Http\Message\{ResponseInterface, ServerRequestInterface};

/**
 * Front middleware, runs prior to regular middleware
 * Front middleware does not run $app->handle.  Instead, it returns a request
 * and optionally a response.
 */
interface FrontwareInterface
{
    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     *
     * The response is provided as a parameter under to premise
     * earlier frontware will start to modify the respone
     * This necessitates that the AppInterface::handle function
     * generates a seed response for the first frontware
     */
     /** return
     < ServerRequestInterface >
     ||
     [< ServerRequestInterface > || < ResponseInterface >, ...]
     */
    public function process(ServerRequestInterface $request, ResponseInterface $response, LayeredAppInterface $app);
}

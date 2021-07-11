<?php

declare(strict_types=1);

namespace Psg\Http\Server;

use Psg\Http\Message\{ResponseInterface, ExitResponseInterface};

/**
 *
 */

interface LayeredAppInterface extends MiddlewareAppInterface
{
    /** Adds starting outerware  */
    /** params.
    < outerware > < BeforewareInterface | closure | class identifier >
     */
    public function before($ware);

    /** Adds ending outerware  */
    /** params.
    < outerware > < AfterwareInterface | closure | class identifier >
     */
    public function after($ware);

    /** Middleware for interacting with the request, but not for building a response  */
    /** params.
    < middleware > < FrontwareInterface | MiddlewareNextInterface | closure | class identifier >
     */
    public function front($ware);

    /** Middleware for interacting with the response, potentially utilizing the request  */
    /** params.
    < middleware > < BackwareInterface | MiddlewareNextInterface | closure | class identifier >
     */
    public function back($ware);

    /** adds ware to a location dependent on ware type */
    /** params.
    < middleware > < MiddlewareInterface | MiddlewareNextInterface | closure | class identifier >
     */
    public function add($middleware);

    /** remove ware */
    /** params.
    < middleware > < MiddlewareInterface | MiddlewareNextInterface | closure | class identifier >
     */
    public function remove($middleware);

    /** returns whether the app currently has the ware (outerware or middleware) somewhere  */
    /** params.
    < middleware > < BeforewareInterface | AfterwareInterface | MiddlewareInterface |
        MiddlewareNextInterface | FrontwareInterface | BackwareInterface | closure | class identifier >
     */
    public function hasWare($ware);

    /** sets the core to be run at the core  */
    /*
    < core > < a callable or instantiable with an invokable >
    */

    public function core($core);

    public function respond(ResponseInterface $response);

    /** produce an ExitResponseInterface for use by Frontware */
    public function createExitResponse(int $code = 200, string $reasonPhrase = ''): ExitResponseInterface;
}

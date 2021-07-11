==== This is not a FIG PSR and has not undergone the rigorous process to become one ====

# PSR 102 App Standardization

PSR 101, the Middleware App, fails some concerns:
-	some "middleware" does not care about either the front or the back, and it should not be forced to care by calling `handle` or `next`
-	some apps need outerware - logic that runs either after the response has been sent, or at the very start, and that is unconcerned with changing the request and response

This has led to LayeredAppInterface.

## Concepts
__Types__
-	Beforeware : outerware for setting of configuration
-	Frontware : middleware caring only about the front
-	Middleware : regular middleware the wraps the core and other middleware
-	Coreware : the core app logic that is wrapped by middleware
-	Backware : middleware caring only about the back
-	Afterware : outerware for doing things after the resopnse, like cleaning up

![Layered App](about/LayeredApp.png?raw=true "Layered App")

__ExitResponseInterface__
For Frontware to force a bypass, because it does not control the flow by calling next, it must return a special response implementing ExitResponseInterface.  It does this through the app factory `$app->createExitResponse`, which is just like `createResponse`.


### Request And Control FLow
The above diagram is an oversimplification.  The reality looks more like this:
![Layered App](about/LA_request_response_flow_variance.png?raw=true "Layered App")

Here you can see that the resopnse is forwarded to the core from the frontware.


### Coreware
In Apps, there is an idea of a core which is usually called the controller.  What is special about this core is that, regardless of what middleware is added during the running of the app, the core will always be executed at the core (whereas, where middleware is executed depends on the list of other middleware).
I decided to call this `core` instead of `control` to make it more generic (it also includes running view code).
I also decided to make this a single callable or {instantiable thing with an __invoke method}.  In my implementation, I provide the callable with the parameters ($request, $response, $app).  It is, however, expectable that frameworks will want to:
-	inject parameters as necessary into the core call
-	inject parameters into the __construct if the core is an instantiable
As such, the parameters are left up to the framework.

Middleware, like a router, can set the core using `$app->core($core)`.  The `$app->core()` method sets this coreware, and will overwrite anything that exists priorhand as the core.
I decided that the coreware should not be multiple.  Coreware is not expected to be generic, it is expected to be specific to the app, so a list is unnecessary.



There is the semblance of a conceptual issue about the `has` function.  Since outerware is now present, and there is front and back specific middleware, what does `has` refer to?


## Extension
I imagine frameworks will want to extend the LayeredApp with FIG PSR-11 and FIG PSR-14.  I may add such an interface to this repo later.


## Example
See [psr-102-implementation](https://github.com/PHP-SG/psr-102-implementation)

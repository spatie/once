<?php

namespace Spatie\Once;

use BadMethodCallException;
use Closure;
use ReflectionFunction;
use ReflectionFunctionAbstract;
use ReflectionMethod;

/**
 * @mixin \ReflectionFunction
 * @mixin \ReflectionMethod
 */
class ReflectionCallable
{
    protected ReflectionFunctionAbstract $reflection;

    public function __construct(callable $callable)
    {
        if ($callable instanceof Closure) {
            $this->reflection = new ReflectionFunction($callable);
        } elseif (is_string($callable)) {
            $parts = explode('::', $callable);

            $this->reflection = count($parts) > 1
                ? new ReflectionMethod($parts[0], $parts[1])
                : new ReflectionFunction($callable);
        } else {
            if (!is_array($callable)) {
                $callable = [$callable, '__invoke'];
            }

            $this->reflection = new ReflectionMethod($callable[0], $callable[1]);
        }
    }

    public function __call(string $name, array $arguments)
    {
        if(method_exists($this->reflection, $name)) {
            return call_user_func_array([$this->reflection, $name], $arguments);
        }

        throw new BadMethodCallException(sprintf('Undefined method %s->%s()', $this::class, $name));
    }
}

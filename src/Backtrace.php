<?php

declare(strict_types=1);

namespace Spatie\Once;
/**
 * @template Trace of array{function: string, line?: int, file?: string, class?: class-string, type?: "->"|"::", args?: array, object?: object}
 */
final class Backtrace
{
    /**
     * @var Trace
     */
    protected array $trace;

    /**
     * @var Trace
     */
    protected array $zeroStack;

    /**
     * @param array<int, Trace> $trace
     */
    public function __construct(array $trace)
    {
        $this->trace = $trace[1];

        $this->zeroStack = $trace[0];
    }

    /**
     * @return mixed[]
     */
    public function getArguments(): array
    {
        return $this->trace['args'];
    }

    public function getFunctionName(): string
    {
        return $this->trace['function'];
    }

    public function getObjectName(): ?string
    {
        return $this->trace['class'] ?? null;
    }

    /**
     * @return string|object
     */
    public function getObject(): mixed
    {
        if ($this->globalFunction()) {
            return $this->zeroStack['file'];
        }
        if ($this->staticCall()) {
            return $this->trace['class'];
        }
        return $this->trace['object'];
    }

    public function getHash(): string
    {
        $normalizedArguments = array_map(function ($argument) {
            return is_object($argument) ? spl_object_hash($argument) : $argument;
        }, $this->getArguments());

        $prefix = $this->getObjectName() . $this->getFunctionName();
        if (str_contains($prefix, '{closure}')) {
            $prefix = $this->zeroStack['line'];
        }

        return md5($prefix.serialize($normalizedArguments));
    }

    protected function staticCall(): bool
    {
        return $this->trace['type'] === '::';
    }

    protected function globalFunction(): bool
    {
        return ! isset($this->trace['type']);
    }
}

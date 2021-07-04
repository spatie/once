<?php

namespace Spatie\Once;

class Backtrace
{
    protected array $trace;

    protected array $zeroStack;

    public function __construct(array $trace)
    {
        $this->trace = $trace[1];

        $this->zeroStack = $trace[0];
    }

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

    public function getObject(): mixed
    {
        if ($this->globalFunction()) {
            return $this->zeroStack['file'];
        }

        return $this->staticCall() ? $this->trace['class'] : $this->trace['object'];
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

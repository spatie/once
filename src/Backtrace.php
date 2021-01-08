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
        $function = $this->trace['function'];

        if (str_contains($function, '{closure}')) {
            $function .= '#'.$this->zeroStack['line'];
        }

        return $function;
    }

    public function getObject(): mixed
    {
        if ($this->globalFunction()) {
            return $this->zeroStack['file'];
        }

        return $this->staticCall() ? $this->trace['class'] : $this->trace['object'];
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

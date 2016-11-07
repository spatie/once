<?php

namespace Spatie\Once;

class Backtrace
{
    /** @var array */
    protected $trace;

    public function __construct(array $trace)
    {
        $this->trace = $trace;
    }

    public function getArguments(): array
    {
        return $this->trace['args'];
    }

    public function getFunctionName(): string
    {
        return $this->trace['function'];
    }

    /**
     * @return mixed
     */
    public function getObject()
    {
        return $this->trace['object'];
    }

    public function getHash(): string
    {
        $normalizedArguments = array_map(function ($argument) {
            return is_object($argument) ? spl_object_hash($argument) : $argument;
        }, $this->getArguments());

        return md5($this->getFunctionName().serialize($normalizedArguments));
    }
}

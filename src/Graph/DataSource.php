<?php

namespace Photogabble\RRDTool\Graph;

use Exception;

class DataSource
{
    const GAUGE = 'GAUGE';
    const COUNTER = 'COUNTER';
    const DERIVE = 'DERIVE';
    const ABSOLUTE = 'ABSOLUTE';

    /**
     * @var string
     */
    private $dst;
    /**
     * @var int
     */
    private $heartbeat;
    /**
     * @var int|null
     */
    private $min;
    /**
     * @var int|null
     */
    private $max;
    /**
     * @var string
     */
    private $name;

    /**
     * GraphDataSource constructor.
     *
     * @param string $name
     * @param string $dst
     * @param int $heartbeat
     * @param int|null $min
     * @param int|null $max
     * @throws Exception
     */
    public function __construct(string $name, string $dst, int $heartbeat, int $min = null, int $max = null)
    {
        $dst = strtoupper($dst);

        if (!in_array($dst, ['GAUGE', 'COUNTER', 'DCOUNTER', 'DERIVE', 'ABSOLUTE', 'COMPUTE'])) {
            throw new Exception(sprintf('The DST [%s] is invalid', $dst));
        }

        if (!(is_null($min) || is_null($max)) && ($max < $min)) {
            throw new Exception('Max value must be greater than Min value');
        }

        $this->dst = $dst;
        $this->heartbeat = $heartbeat;
        $this->min = $min;
        $this->max = $max;
        $this->name = $name;
    }

    /**
     * DS:ds-name:DST:heartbeat:min:max
     *
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('DS:%s:%s:%d:%s:%s',
            $this->name,
            $this->dst,
            $this->heartbeat,
            is_null($this->min) ? 'U' : (string)$this->min,
            is_null($this->max) ? 'U' : (string)$this->max
        );
    }
}
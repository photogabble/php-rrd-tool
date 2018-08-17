<?php

namespace Photogabble\RRDTool\Graph;

use Exception;

class RoundRobbinArchive
{
    const AVERAGE = 'AVERAGE';
    const MIN = 'MIN';
    const MAX = 'MAX';
    const LAST = 'LAST';

    /**
     * @var string
     */
    private $cf;
    /**
     * @var int
     */
    private $steps;
    /**
     * @var int
     */
    private $rows;
    /**
     * @var float
     */
    private $xff;

    /**
     * RoundRobbinArchive constructor.
     * @param string $cf
     * @param int $steps
     * @param int $rows
     * @param float $xff
     * @throws Exception
     */
    public function __construct(string $cf, int $steps, int $rows, float $xff = 0.5)
    {
        $cf = strtoupper($cf);

        if (!in_array($cf, ['AVERAGE', 'MIN', 'MAX', 'LAST'])) {
            throw new Exception(sprintf('The consolidation function [%s] is invalid', $cf));
        }

        $this->cf = $cf;
        $this->steps = $steps;
        $this->rows = $rows;
        $this->xff = $xff;
    }

    /**
     * RRA:CF:xff:steps:rows
     *
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('RRA:%s:%g:%d:%d',
            $this->cf,
            $this->xff,
            $this->steps,
            $this->rows
        );
    }
}
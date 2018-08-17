<?php

namespace Photogabble\RRDTool;

use Exception;
use Photogabble\RRDTool\Graph\DataSource;
use Photogabble\RRDTool\Graph\RoundRobbinArchive;

/**
 * Class Graph
 *
 * Class version of rrdcreate
 *
 * @package Photogabble\RRDTool
 */
class Graph
{
    const SECOND = 1;
    const MINUTE = self::SECOND * 60;
    const HOUR = self::MINUTE * 60;
    const DAY = self::HOUR * 24;
    const WEEK = self::DAY * 7;
    const YEAR = self::DAY * 365;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $step;

    /**
     * @var DataSource[]
     */
    private $ds = [];

    /**
     * @var RoundRobbinArchive[]
     */
    private $rra = [];

    /**
     * Start Time
     *
     * @var int
     */
    private $start;

    /**
     * RDDGraph constructor.
     *
     * @param string $name
     * @param int $step
     * @param int $start
     */
    public function __construct(string $name, int $step, int $start = null)
    {
        $this->name = $name;
        $this->step = $step;
        $this->start = (is_null($start) ? time() - 10 : $start);
    }

    /**
     * Add a Data Source to this Graph.
     *
     * @param string $name
     * @param string $dst
     * @param int $heartbeat
     * @param int|null $min
     * @param int|null $max
     * @throws Exception
     */
    public function addDataSource(string $name, string $dst, int $heartbeat, int $min = null, int $max = null)
    {
        $this->ds[$name] = new DataSource($name, $dst, $heartbeat, $min, $max);
    }

    /**
     * Add a RRA to this Graph.
     *
     * RRA:CF:xff:steps:rows
     *
     * In order to calculate $resolution we need to look at $this->step property. If
     * $step is 300 (5 minutes) that will result in:
     *
     * value of steps   how often a value is saved  resolution      how to get the number
     * 1	            every time                  5 minutes	    1 * 300s = 5m
     * 3	            every third time	        15 minutes	    3 * 300s = 15m
     * 6	            every 6th time	            half an hour	6 * 300s = 30m
     * 12	            every 12th time	            one hour	    12 * 300s = 1h
     * 72	            every 72th time	            six hours	    72 * 300s = 6h
     * 144	            every 144th time	        12 hours	    144 * 300s = 12h
     * 288	            every 288th time	        24 hours	    288 * 300s = 24h
     *
     * In order to calculate the $rows (the number of steps that can be stored in
     * and archive,) you need to divide the wanted time span with the resolution.
     *
     * e.g.
     * 24 hours with 30-minute resolution:
     * 24 hours in seconds: 60*60*24 = 86400s
     * 30 minutes in seconds: 60*30 = 1800s
     * 86400/1800 = 48
     *
     * @see https://apfelboymchen.net/gnu/rrd/create/
     * @see https://oss.oetiker.ch/rrdtool/doc/rrdcreate.en.html
     *
     * @param string $cf
     * @param float $xff
     * @param int $resolution (seconds)
     * @param int $timeSpan (seconds)
     * @throws Exception
     */
    public function addRoundRobbinArchive(string $cf, int $resolution, int $timeSpan, float $xff = 0.5)
    {
        $steps = floor($resolution/$this->step);
        $rows = $timeSpan / $resolution;

        $this->rra[] = new RoundRobbinArchive($cf, $steps, $rows, $xff);
    }

    /**
     * Returns the command line instruction for
     * creating this graphs rrd file.
     *
     * @return string
     */
    public function __toString(): string
    {
        $rows = [
            'rrdtool',
            sprintf('create %s.rrd', $this->name),
            sprintf('--step %d', $this->step),
            sprintf('--start %d', $this->start)
        ];

        foreach ($this->ds as $dataSource) {
            $rows[] = (string) $dataSource;
        }
        foreach($this->rra as $archive) {
            $rows[] = (string) $archive;
        }
        return implode(' ', $rows);
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'step' => $this->step,
            'start' => $this->start,
            'ds' => $this->ds,
            'rra' => $this->rra
        ];
    }
}
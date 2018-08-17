<?php

namespace Photogabble\ConfusableHomoglyphs\Tests;

use Photogabble\RRDTool\RRDCreate;
use Photogabble\RRDTool\Graph\DataSource;
use Photogabble\RRDTool\Graph\RoundRobbinArchive;
use PHPUnit\Framework\TestCase;

class RRDCreateTest extends TestCase
{
    public function testGraph()
    {
        try {
            $now = time();
            $graph = new RRDCreate('test', 300, $now);

            $this->assertEquals([
                'name' => 'test.rrd',
                'step' => 300,
                'start' => $now,
                'ds' => [],
                'rra' => []

            ], $graph->toArray());

            $graph->addDataSource('inet_down_total', DataSource::DERIVE, 600, 0);
            $graph->addDataSource('inet_down_comp1', DataSource::DERIVE, 600, 0);
            $graph->addDataSource('inet_down_comp2', DataSource::DERIVE, 600, 0);
            $graph->addDataSource('inet_down_other', DataSource::DERIVE, 600, 0);

            // Day in 5 minute resolution
            $graph->addRoundRobbinArchive(RoundRobbinArchive::AVERAGE, RRDCreate::MINUTE * 5, RRDCreate::DAY);

            // Week in 15 minute resolution
            $graph->addRoundRobbinArchive(RoundRobbinArchive::AVERAGE, RRDCreate::MINUTE * 15, RRDCreate::WEEK);

            // Month (give or take) in 1 hour resolution
            $graph->addRoundRobbinArchive(RoundRobbinArchive::AVERAGE, RRDCreate::HOUR, RRDCreate::DAY * 31);

            // Year in 6 hour resolution
            $graph->addRoundRobbinArchive(RoundRobbinArchive::AVERAGE, RRDCreate::HOUR * 6, RRDCreate::YEAR);

            $expected = 'rrdtool create test.rrd ' .
                '--step 300 ' .
                '--start ' . $now . ' ' .
                'DS:inet_down_total:DERIVE:600:0:U ' .
                'DS:inet_down_comp1:DERIVE:600:0:U ' .
                'DS:inet_down_comp2:DERIVE:600:0:U ' .
                'DS:inet_down_other:DERIVE:600:0:U ' .
                'RRA:AVERAGE:0.5:1:288 ' .
                'RRA:AVERAGE:0.5:3:672 ' .
                'RRA:AVERAGE:0.5:12:744 ' .
                'RRA:AVERAGE:0.5:72:1460';

            $this->assertEquals($expected, (string)$graph);
        } catch (\Exception $e) {
            $this->fail($e);
        }
    }
}
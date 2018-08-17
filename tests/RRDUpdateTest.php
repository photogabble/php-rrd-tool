<?php

namespace Photogabble\ConfusableHomoglyphs\Tests;

use Photogabble\RRDTool\Graph\Update;
use Photogabble\RRDTool\RRDUpdate;
use PHPUnit\Framework\TestCase;

class RRDUpdateTest extends TestCase
{
    public function testRRDUpdate()
    {
        try {
            $this->assertEquals('rrdtool update test.rrd', (string) new RRDUpdate('test.rrd'));
            $this->assertEquals('rrdtool update test.rrd --skip-past-updates', (string) new RRDUpdate('test.rrd', true));
            $this->assertEquals('rrdtool updatev test.rrd', (string) new RRDUpdate('test.rrd', false, true));

            $update = new RRDUpdate('demo1.rrd');
            $update->addUpdates([
                new Update([3.44,3.15, 'U',23])
            ]);
            $this->assertEquals('rrdtool update demo1.rrd N:3.44:3.15:U:23', (string) $update);

            $update = new RRDUpdate('demo2.rrd');
            $update->addUpdates([
                new Update(['U'], 887457267),
                new Update([22], 887457521),
                new Update([2.7], 887457903),
            ]);
            $this->assertEquals('rrdtool update demo2.rrd 887457267:U 887457521:22 887457903:2.7', (string) $update);

            $update = new RRDUpdate('demo3.rrd');
            $update->addUpdates([
                new Update([21], -5),
                new Update([42]),
            ]);
            $this->assertEquals('rrdtool update demo3.rrd -- -5:21 N:42', (string) $update);

        } catch (\Exception $e) {
            $this->fail($e);
        }
    }
}
<?php

namespace Photogabble\ConfusableHomoglyphs\Tests;

use Photogabble\RRDTool\Graph\DataSource;
use PHPUnit\Framework\TestCase;

class DataSourceTest extends TestCase
{
    public function testGraphDataSource()
    {
        try {
            $this->assertEquals(
                'DS:test:GAUGE:1:U:U',
                (string)new DataSource('test', 'gauge', 1)
            );
            $this->assertEquals(
                'DS:test:GAUGE:20:U:U',
                (string)new DataSource('test', 'GAUGE', 20)
            );
            $this->assertEquals(
                'DS:test:COUNTER:300:U:U',
                (string)new DataSource('test', 'COUNTER', 300)
            );
            $this->assertEquals(
                'DS:test:DERIVE:4000:U:U',
                (string)new DataSource('test', 'DERIVE', 4000)
            );
            $this->assertEquals(
                'DS:test:ABSOLUTE:50000:U:U',
                (string)new DataSource('test', 'ABSOLUTE', 50000)
            );
            $this->assertEquals(
                'DS:test:ABSOLUTE:50000:-100:U',
                (string)new DataSource('test', 'ABSOLUTE', 50000, -100)
            );
            $this->assertEquals(
                'DS:test:ABSOLUTE:50000:0:U',
                (string)new DataSource('test', 'ABSOLUTE', 50000, 0)
            );
            $this->assertEquals(
                'DS:test:ABSOLUTE:50000:100:U',
                (string)new DataSource('test', 'ABSOLUTE', 50000, 100)
            );
            $this->assertEquals(
                'DS:test:ABSOLUTE:50000:0:100',
                (string)new DataSource('test', 'ABSOLUTE', 50000, 0, 100)
            );
            $this->assertEquals(
                'DS:test:ABSOLUTE:50000:U:100',
                (string)new DataSource('test', 'ABSOLUTE', 50000, null, 100)
            );
            $this->assertEquals('DS:test:ABSOLUTE:50000:U:-100',
                (string)new DataSource('test', 'ABSOLUTE', 50000, null, -100)
            );
        } catch (\Exception $e) {
            $this->fail($e);
        }
    }

    /**
     * @throws \Exception this line shushes phpstorm
     */
    public function testGraphDataSourceExceptions()
    {
        $this->expectExceptionMessage('The DST [HELLO_WORLD] is invalid');
        new DataSource('test', 'HELLO_WORLD', 300);

        $this->expectExceptionMessage('Max value must be greater than Min value');
        new DataSource('test', 'ABSOLUTE', 300, 0, -100);
    }

}
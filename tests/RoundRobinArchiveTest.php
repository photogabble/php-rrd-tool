<?php

namespace Photogabble\ConfusableHomoglyphs\Tests;

use Photogabble\RRDTool\Graph\RoundRobbinArchive;
use PHPUnit\Framework\TestCase;

class RoundRobinArchiveTest extends TestCase
{
    public function testRoundRobbinArchive()
    {
        try {
            $this->assertEquals(
                'RRA:AVERAGE:0.5:1:288',
                (string)new RoundRobbinArchive('average', 1, 288)
            );
            $this->assertEquals(
                'RRA:AVERAGE:0.5:1:288',
                (string)new RoundRobbinArchive('AVERAGE', 1, 288)
            );
            $this->assertEquals(
                'RRA:MIN:0.5:3:672',
                (string)new RoundRobbinArchive('MIN', 3, 672)
            );
            $this->assertEquals(
                'RRA:MAX:0.5:12:744',
                (string)new RoundRobbinArchive('MAX', 12, 744)
            );
            $this->assertEquals(
                'RRA:LAST:0.5:72:1460',
                (string)new RoundRobbinArchive('LAST', 72, 1460)
            );

            $this->assertEquals(
                'RRA:LAST:1.5:72:1460',
                (string)new RoundRobbinArchive('LAST', 72, 1460, 1.5)
            );
        } catch (\Exception $e) {
            $this->fail($e);
        }
    }

    /**
     * @throws \Exception this line shushes phpstorm
     */
    public function testRoundRobbinArchiveExceptions()
    {
        $this->expectExceptionMessage('The consolidation function [HELLO_WORLD] is invalid');
        new RoundRobbinArchive('HELLO_WORLD', 1, 1);
    }
}
<?php

namespace Photogabble\ConfusableHomoglyphs\Tests;

use Photogabble\RRDTool\Graph\Update;
use PHPUnit\Framework\TestCase;

class UpdateTest extends TestCase
{
    public function testUpdate()
    {
        try {
            $this->assertEquals('N:3.44:3.15:U:23', (string) new Update([3.44,3.15,'U',23]));
            $this->assertEquals('887457267:U', (string) new Update(['U'], 887457267));
            $this->assertEquals('887457267:U', (string) new Update(null, 887457267));
            $this->assertEquals('N:U', (string) new Update());
            $this->assertEquals('-- -5:21', (string) new Update([21], -5));
            $this->assertEquals('"july 9 1998 18:20@3210"', (string) new Update([3210], "july 9 1998 18:20"));
        } catch (\Exception $e) {
            $this->fail($e);
        }
    }
}
<?php

namespace Photogabble\RRDTool;

class RRDBase
{

    /**
     * @var string
     */
    protected $filename;

    public function __construct(string $filename)
    {
        if (strpos($filename, '.rrd') === false) {
            $filename.='.rrd';
        }
        $this->filename = $filename;
    }

}
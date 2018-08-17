<?php

namespace Photogabble\RRDTool\Graph;

class Update
{
    /**
     * @var array
     */
    private $values;
    /**
     * @var null|string
     */
    private $time;

    /**
     * @var string
     */
    private $separators = ':';

    /**
     * Update constructor.
     * @param array $values
     * @param null|string $time
     */
    public function __construct(array $values = null, string $time = null)
    {
        if (is_null($values)){
            $values = ['U'];
        }

        $this->values = $values;
        $this->time = is_null($time) ? 'N' : $time;

        if (strpos($this->time, ' ') !== false){
            $this->separators = '@';
        }
    }

    public function __toString(): string
    {
        $rows = [
            ($this->time < 0) ? "-- {$this->time}" : $this->time
        ];

        $rows = array_merge($rows, $this->values);
        $return = implode($this->separators, $rows);

        if ($this->separators === '@') {
            $return = '"'.$return.'"';
        }

        return $return;
    }
}
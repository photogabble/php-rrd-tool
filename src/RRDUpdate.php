<?php

namespace Photogabble\RRDTool;

use Photogabble\RRDTool\Graph\Update;

/**
 * Class RRDUpdate
 *
 * @see https://oss.oetiker.ch/rrdtool/doc/rrdupdate.en.html
 */
class RRDUpdate extends RRDBase
{
    /**
     * Use updatev command instead of update.
     *
     * @var bool
     */
    private $verbose = false;

    /**
     * @var null|string
     */
    private $template;

    /**
     * @var Update[]
     */
    private $updates = [];

    /**
     * When updateing an rrd file with data earlier than the latest
     * update already applied, rrdtool will issue an error message
     * an abort. This option instructs rrdtool to silently skip
     * such data. It can be useful when re-playing old data
     * into an rrd file and you are not sure how many
     * updates have already been applied.
     *
     * @var bool
     */
    private $skipPastUpdates = false;

    /**
     * RRDUpdate constructor.
     * @param string $filename
     * @param bool $skipPastUpdates
     * @param bool $verbose
     * @param null $template
     */
    public function __construct(string $filename, $skipPastUpdates = false, $verbose = false, $template = null)
    {
        parent::__construct($filename);
        $this->verbose = $verbose;
        $this->template = $template;
        $this->skipPastUpdates = $skipPastUpdates;
    }

    public function __toString(): string
    {
        $rows = [
            'rrdtool',
            sprintf('%s %s', ($this->verbose === true ? 'updatev' : 'update'), $this->filename),
        ];

        if ($this->skipPastUpdates === true) {
            $rows[] = '--skip-past-updates';
        }

        foreach ($this->updates as $update)
        {
            $rows[] = (string) $update;
        }

        return implode(' ' , $rows);
    }

    /**
     * @param Update $update
     */
    public function addUpdate(Update $update){
        $this->updates[] = $update;
    }

    /**
     * @param Update[] $updates
     */
    public function addUpdates(array $updates)
    {
        foreach($updates as $update)
        {
            $this->addUpdate($update);
        }
    }
}
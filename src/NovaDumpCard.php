<?php

namespace Nembie\NovaDumpCard;

use Laravel\Nova\Card;

class NovaDumpCard extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = '1/3';

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'nova-dump-card';
    }

    /**
     * Set the path to the dump binary.
     *
     * @param string $path
     * @return $this
     */
    public function sqlDumpPath($path)
    {
        return $this->withMeta(['sqlDumpPath' => $path]);
    }

    /**
     * Set the path where the dump will be stored.
     *
     * @param string $path
     * @return $this
     */
    public function dumpPath($path)
    {
        return $this->withMeta(['dumpPath' => $path]);
    }

    /**
     * Set the name of the database.
     *
     * @param string $database
     * @return $this
     */
    public function database($database)
    {
        return $this->withMeta(['database' => $database]);
    }
}

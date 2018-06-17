<?php

namespace Davaxi\VCalendar\_;

/**
 * Trait Process
 * @package Davaxi\VCalendar\_
 */
Trait Process
{
    /**
     * @var string
     */
    protected $processOwner;

    /**
     * @var string
     */
    protected $processName;

    /**
     * @var string
     */
    protected $processVersion;

    /**
     * @var string
     */
    protected $processLang;

    /**
     * @param array $result
     */
    protected function computeProcess(array &$result)
    {
        $result[] = sprintf("PRODID:-//%s//%s %s//%s",
            $this->processOwner,
            $this->processName,
            $this->processVersion,
            $this->processLang
        );
    }

    /**
     * @param $processOwner string
     * @param $processName string
     * @param $processVersion string
     * @param $processLang string
     */
    public function setProcess($processOwner, $processName, $processVersion, $processLang)
    {
        $this->processOwner = $processOwner;
        $this->processName = $processName;
        $this->processVersion = $processVersion;
        $this->processLang = $processLang;
    }
}
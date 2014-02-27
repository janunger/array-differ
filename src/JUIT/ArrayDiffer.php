<?php

namespace JUIT;

class ArrayDiffer
{
    const DEFAULT_FROM_HEADER = 'FROM';
    const DEFAULT_TO_HEADER = 'TO';

    /**
     * @var string
     */
    private $fromHeader;

    /**
     * @var string
     */
    private $toHeader;

    public function __construct($fromHeader = self::DEFAULT_FROM_HEADER, $toHeader = self::DEFAULT_TO_HEADER)
    {
        $this->fromHeader = $fromHeader;
        $this->toHeader = $toHeader;
    }

    public function diff($from, $to)
    {
        if ($from === $to) {
            return [];
        }
        if (is_array($from)) {
            return $this->loopDiff($from, $to);
        }
        return [$this->fromHeader => $from, $this->toHeader => $to];
    }

    private function loopDiff($from, $to)
    {
        $result = [];

        foreach ($from as $key => $value) {
            if (isset($to[$key])) {
                $diff = $this->diff($from[$key], $to[$key]);
                if ($diff) {
                    $result[$key] = $diff;
                }
            } else {
                $result[$key] = [$this->fromHeader => $from[$key]];
            }
        }

        foreach ($to as $key => $value) {
            if (isset($from[$key])) {
                continue;
            }
            $result[$key] = [$this->toHeader => $to[$key]];
        }

        return $result;
    }
}

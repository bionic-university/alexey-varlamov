<?php

namespace Vav;


/**
 * Interface Check
 */
interface CheckInterface
{
    /**
     * @param \SplObjectStorage $storage - inspected object
     * @param string $license - required level
     * @return string $message
     */
    public function check(\SplObjectStorage $storage, $license);
} 
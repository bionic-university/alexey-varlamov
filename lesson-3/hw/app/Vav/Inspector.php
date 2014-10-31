<?php

namespace Vav;


/**
 * Class Inspector
 */
class Inspector implements CheckInterface
{
    public function check(\SplObjectStorage $storage, $license)
    {
        $result = '';
        $storage->rewind();
        while ($storage->valid()) {
            if ($license === $storage->current()->getCategory()) {
                $result = 'Your driving license contains the category "'.$storage->current()->getCategory().'". ';
                $result .= 'You can drive '.$storage->current()->getType().'.';
                $storage->detach($storage->current());
                break;
            }
            $storage->next();
        }

        return $result;
    }
} 
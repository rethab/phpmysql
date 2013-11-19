<?php

/**
 * Iterator Pattern. Needs renaming due to naming conflict with std stuff
 */

interface MyIterator {
    public function hasNext();   
    public function next();
}

class MyArrayIterator implements MyIterator {
    private $vals;
    private $idx = 0;
    
    public function __construct(array $vals) {
        $this->vals = $vals;
    }

    public function hasNext() {
        return $this->idx < count($this->vals);    
    }

    public function next() {
        return $this->vals[$this->idx++];    
    }
}

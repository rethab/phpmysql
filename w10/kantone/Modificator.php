<?php

// Decorator Pattern is used to modify stuff, iterator pattern is used below to, well, iterate


interface Component {
    public function get_value();
}

abstract class ModificationDecorator implements Component {
    private $decorated;
    public function __construct(Component $decorated) {
        $this->decorated = $decorated;
    }
    public function get_value() {
        return $this->decorated->get_value();
    }
}

class Word implements Component {
    private $value;
    public function get_value() {
        return $this->value;    
    }
}

class GermanToEnglishModification implements ModificationDecorator {
    public function __construct(ModificationDecorator $decorated) {
        parent::__construct($decorated);    
    }

    public function get_value() {
        switch (parent::get_value()) {
            case 'Kuerzel':       return 'Shortname';
            case 'Kanton':        return 'Canton';
            case 'Standesstimme': return 'Voices';
            case 'Beitritt':      return 'Joined';
            case 'Hauptort':      return 'Capital';
            case 'Einwohner 1':   return 'Population';
            case 'Auslaender 2':  return 'Foreignes';
            case 'Flaeche 3':     return 'Area';
            case 'Dichte 4':      return 'Density';
            case 'Gemeinden 6':   return 'Communs';
            case 'Amtssprache':   return 'Language';
            default:              return parent::get_value();
        }
    }
}

class LowercaseModification implements ModificationDecorator {
    public function __construct(ModificationDecorator $decorated) {
        parent::__construct($decorated);    
    }

    public function get_value() {
        return strtolower(parent::get_value());
    }
}

class CaesarModification implements ModificationDecorator {
    public function __construct(ModificationDecorator $decorated) {
        parent::__construct($decorated);    
    }

    public function get_value() {
        $encrypted = array();
        $characterIterator = new MyArrayIterator(str_split(parent::get_value()));
        while ($characterIterator->hasNext()) {
            $char = $characterIterator->next();
            $encrypted[] = $this->rotate($char, $n);
        }
    }

    public function rotate($char, $n) {
        return chr(ord($char) + $n);
    }

}

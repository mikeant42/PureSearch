<?php


function getElementsByClassName(DOMDocument $domNode, $className) {
    $elements = $domNode->getElementsByTagName('*');
    $matches = array();
    foreach($elements as $element) {
        if ( ! $element->hasAttribute('class')) {
            continue;
        }
        $classes = preg_split('/\s+/', $element->getAttribute('class'));
        if ( ! in_array($className, $classes)) {
            continue;
        }
        $matches[] = $element;
    }
   	return $matches[0]->nodeValue;
}
?>
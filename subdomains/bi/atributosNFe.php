<?

function findValue($element) {
    $tagName = $element->getName();
    $value = (string) $element;

    if ($value) {
        echo "Tag: $tagName, Valor: $value<br>";
    } else {
        foreach ($element->children() as $childElement) {
            findValue($childElement);
        }
    }
}

$xmlData="";

$xml = simplexml_load_string($xmlData); // Substitua $seuXml pelo seu XML real

foreach ($xml->children() as $element) {
    findValue($element);
}

?>

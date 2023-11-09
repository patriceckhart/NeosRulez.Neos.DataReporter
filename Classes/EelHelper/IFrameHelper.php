<?php
namespace NeosRulez\Neos\DataReporter\EelHelper;

use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Flow\Annotations as Flow;

/**
 * @Flow\Proxy(false)
 */
class IFrameHelper implements ProtectedContextAwareInterface
{

    /**
     * Filter iFrames and replace it with data reporters placeholder
     *
     * @param string $originalRenderer
     * @param string $divCssClassName
     * @return string
     */
    public function filter(string $originalRenderer, string $divCssClassName): string
    {
        return $this->replaceOriginalString($originalRenderer, $this->getIFrames($originalRenderer, $divCssClassName));
    }

    /**
     * @param string $string
     * @param array $iFrames
     * @return string
     */
    private function replaceOriginalString(string $string, array $iFrames): string
    {
        foreach ($iFrames as $iFrame) {
            $string = str_replace($iFrame['stringToBeReplaced'], $iFrame['stringToReplace'], $string);
        }
        return $string;
    }

    /**
     * @param string $string
     * @param string $divCssClassName
     * @return array
     */
    private function getIFrames(string $string, string $divCssClassName): array
    {
        $dom = new \DOMDocument();
        $html = $string;
        libxml_use_internal_errors(true);
        @$dom->loadHTML($html);
        $a = $dom->getElementsByTagName('iframe');
        $result = [];
        for ($i = 0; $i < $a->length; $i++) {
            $src = $a->item($i)->getAttribute('src');
            $width = $a->item($i)->getAttribute('width');
            $height = $a->item($i)->getAttribute('height');
            $style = $a->item($i)->getAttribute('style');
            $originalIFrame = $dom->saveHTML($a->item($i));
            $result[] = [
                'stringToBeReplaced' => html_entity_decode($originalIFrame),
                'stringToReplace' => '<div class="' . $divCssClassName . '" data-iframe-url="' . $src . '" data-width="' . $width . '" data-height="' . $height . '" style="' . $style . '"></div>'
            ];
        }
        return $result;
    }

    /**
     * All methods are considered safe
     *
     * @param string $methodName The name of the method
     * @return bool
     */
    public function allowsCallOfMethod($methodName)
    {
        return true;
    }

}

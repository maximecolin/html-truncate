<?php

/*
 * This file is part of the HtmlTruncate package.
 *
 * (c) Maxime Colin <contact@maximecolin.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlTruncate;

class HtmlTruncate
{
    /**
     * @param string $html
     * @param int    $length
     * @param string $append
     *
     * @return string
     */
    public function truncate($html, $length, $append = '...')
    {
        $document = new \DOMDocument();
        libxml_use_internal_errors(true);
        $document->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOBLANKS);
        libxml_clear_errors();

        $nodes = $this->getTextNodes($document);

        $currentLength = 0;


        foreach ($nodes as $node) {

            $nodeLength = mb_strlen(trim($node->nodeValue), 'UTF-8');

            if ($currentLength > $length) {

                // Get text node parent
                $node = $node->parentNode;

                // Remove all next siblings
                while ($node->nextSibling) {
                    $node->parentNode->removeChild($node->nextSibling);
                }

                // Remove all parents next siblings
                $parent = $node;
                while ($parent->parentNode) {
                    $parent = $parent->parentNode;
                    while ($parent->nextSibling) {
                        $parent->parentNode->removeChild($parent->nextSibling);
                    }
                }

                // Remove current node
                $node->parentNode->removeChild($node);

                // Stop iterating through text node
                break;
            } elseif ($currentLength + $nodeLength > $length) {
                // Cut the current text node value
                $node->nodeValue = mb_substr($node->nodeValue, 0, $length - $currentLength, 'UTF-8') . $append;
                $currentLength += $nodeLength;
            } else {
                // Sum the length
                $currentLength += $nodeLength;
            }
        }

        return $document->saveHTML();
    }

    /**
     * @param \DOMDocument $document
     *
     * @return \DOMNodeList
     */
    private function getTextNodes(\DOMDocument $document)
    {
        $xpath = new \DOMXPath($document);

        return $xpath->query('//text()');
    }
}


<?php

class BBCParser extends Golonka\BBCode\Facades\BBCodeParser{

    public $availableParsers = array(
        'bold' => array(
            'pattern' => '/\[b\]([\s\S]+?)\[\/b\]/',
            'replace' => '<strong>$1</strong>'
        ),
        'italic' => array(
            'pattern' => '/\[i\]([\s\S]+?)\[\/i\]/',
            'replace' => '<em>$1</em>'
        ),
        'underLine' => array(
            'pattern' => '/\[u\]([\s\S]+?)\[\/u\]/',
            'replace' => '<u>$1</u>'
        ),
        'lineThrough' => array(
            'pattern' => '/\[s\]([\s\S]+?)\[\/s\]/',
            'replace' => '<span class="strike">$1</span>'
        ),
        'fontSize' => array(
            'pattern' => '/\[size\=([1-7])\]([\s\S]+?)\[\/size\]/',
            'replace' => '<span class="size$1">$2</span>'
        ),
        'fontColor' => array(
            'pattern' => '/\[color\=(#[A-f0-9]{6}|#[A-f0-9]{3})\]([\s\S]+?)\[\/color\]/',
            'replace' => '<font color="$1">$2</font>'
        ),
        'center' => array(
            'pattern' => '/\[center\]([\s\S]+?)\[\/center\]/',
            'replace' => '<div class="text-center">$1</div>'
        ),
        'left' => array(
            'pattern' => '/\[left\]([\s\S]+?)\[\/left\]/',
            'replace' => '<div class="text-left">$1</div>'
        ),
        'right' => array(
            'pattern' => '/\[right\]([\s\S]+?)\[\/right\]/',
            'replace' => '<div class="text-right">$1</div>'
        ),
        'quote' => array(
            'pattern' => '/\[quote\]([\s\S]+?)\[\/quote\]/',
            'replace' => '<blockquote>$1</blockquote>'
        ),
        'namedQuote' => array(
            'pattern' => '/\[quote\=([\s\S]+?)\]([\s\S]+?)\[\/quote\]/',
            'replace' => '<blockquote><small>$1</small>$2</blockquote>'
        ),
        'link' => array(
            'pattern' => '/\[url\]([\s\S]+?)\[\/url\]/',
            'replace' => '<a href="$1">$1</a>'
        ),
        'namedLink' => array(
            'pattern' => '/\[url\=([\s\S]+?)\]([\s\S]+?)\[\/url\]/',
            'replace' => '<a href="$1">$2</a>'
        ),
        'image' => array(
            'pattern' => '/\[img\]([\s\S]+?)\[\/img\]/',
            'replace' => '<img src="$1">'
        ),
        'orderedListNumerical' => array(
            'pattern' => '/\[list=1\]([\s\S]+?)\[\/list\]/s',
            'replace' => '<ol>$1</ol>',
        ),
        'orderedListAlpha' => array(
            'pattern' => '/\[list=a\]([\s\S]+?)\[\/list\]/s',
            'replace' => '<ol type="a">$1</ol>',
        ),
        'orderedListDeprecated' => array(
            'pattern' => '/\[ol\]([\s\S]+?)\[\/ol\]/s',
            'replace' => '<ol>$1</ol>',
        ),
        'unorderedList' => array(
            'pattern' => '/\[list\]([\s\S]+?)\[\/list\]/s',
            'replace' => '<ul>$1</ul>',
        ),
        'unorderedListDeprecated' => array(
            'pattern' => '/\[ul\]([\s\S]+?)\[\/ul\]/s',
            'replace' => '<ul>$1</ul>',
        ),
        'listItem' => array(
            'pattern' => '/\[\*\](.*)/',
            'replace' => '<li>$1</li>'
        ),
        'code' => array(
            'pattern' => '/\[code\]([\s\S]+?)\[\/code\]/',
            'replace' => '<code>$1</code>'
        ),
        'youtube' => array(
            'pattern' => '/\[video\]([\s\S]+?)\[\/video\]/',
            'replace' => '<div class="embed-responsive embed-responsive-16by9">
                              <iframe class="embed-responsive-item" src="//www.youtube.com/embed/$1" allowfullscreen></iframe></div>'
        ),
        'linebreak' => array(
            'pattern' => '/\r/',
            'replace' => '<br>',
        )
    );

    public $unParsers = array(
        'bold' => array(
            'pattern' => '/\[b\]([\s\S]+?)\[\/b\]/',
            'replace' => '$1'
        ),
        'italic' => array(
            'pattern' => '/\[i\]([\s\S]+?)\[\/i\]/',
            'replace' => '$1'
        ),
        'underLine' => array(
            'pattern' => '/\[u\]([\s\S]+?)\[\/u\]/',
            'replace' => '$1'
        ),
        'lineThrough' => array(
            'pattern' => '/\[s\]([\s\S]+?)\[\/s\]/',
            'replace' => '$1'
        ),
        'fontSize' => array(
            'pattern' => '/\[size\=([1-7])\]([\s\S]+?)\[\/size\]/',
            'replace' => '$2'
        ),
        'fontColor' => array(
            'pattern' => '/\[color\=(#[A-f0-9]{6}|#[A-f0-9]{3})\]([\s\S]+?)\[\/color\]/',
            'replace' => '$2'
        ),
        'center' => array(
            'pattern' => '/\[center\]([\s\S]+?)\[\/center\]/',
            'replace' => '$1'
        ),
        'left' => array(
            'pattern' => '/\[left\]([\s\S]+?)\[\/left\]/',
            'replace' => '$1'
        ),
        'right' => array(
            'pattern' => '/\[right\]([\s\S]+?)\[\/right\]/',
            'replace' => '$1'
        ),
        'quote' => array(
            'pattern' => '/\[quote\]([\s\S]+?)\[\/quote\]/',
            'replace' => '$1'
        ),
        'namedQuote' => array(
            'pattern' => '/\[quote\=([\s\S]+?)\]([\s\S]+?)\[\/quote\]/',
            'replace' => '$2'
        ),
        'link' => array(
            'pattern' => '/\[url\]([\s\S]+?)\[\/url\]/',
            'replace' => '$1'
        ),
        'namedLink' => array(
            'pattern' => '/\[url\=([\s\S]+?)\]([\s\S]+?)\[\/url\]/',
            'replace' => '$2'
        ),
        'image' => array(
            'pattern' => '/\[img\]([\s\S]+?)\[\/img\]/',
            'replace' => '$1'
        ),
        'orderedListNumerical' => array(
            'pattern' => '/\[list=1\]([\s\S]+?)\[\/list\]/s',
            'replace' => '$1',
        ),
        'orderedListAlpha' => array(
            'pattern' => '/\[list=a\]([\s\S]+?)\[\/list\]/s',
            'replace' => '$1',
        ),
        'orderedListDeprecated' => array(
            'pattern' => '/\[ol\]([\s\S]+?)\[\/ol\]/s',
            'replace' => '$1',
        ),
        'unorderedList' => array(
            'pattern' => '/\[list\]([\s\S]+?)\[\/list\]/s',
            'replace' => '$1',
        ),
        'unorderedListDeprecated' => array(
            'pattern' => '/\[ul\]([\s\S]+?)\[\/ul\]/s',
            'replace' => '$1',
        ),
        'listItem' => array(
            'pattern' => '/\[\*\](.*)/',
            'replace' => '$1'
        ),
        'code' => array(
            'pattern' => '/\[code\]([\s\S]+?)\[\/code\]/',
            'replace' => '$1'
        ),
        'youtube' => array(
            'pattern' => '/\[video\]([\s\S]+?)\[\/video\]/',
            'replace' => 'www.youtube.com/embed/$1'
        ),
        'linebreak' => array(
            'pattern' => '/\r/',
            'replace' => '<br>',
        )
    );

    private $parsers;

    public function __construct(array $parsers = null)
    {
        $this->parsers = ($parsers === null) ? $this->availableParsers : $parsers;
    }

    /**
     * @param  string $source String containing the BBCode
     * @return string Parsed string
     *  parses the BBCode string
     */
    public function parse($source)
    {
        foreach ($this->parsers as $name => $parser) {
            if(isset($parser['iterate']))
            {
                for ($i=0; $i <= $parser['iterate']; $i++) {
                    $source = preg_replace($parser['pattern'], $parser['replace'], $source);
                }
            }
            else {
                $source = preg_replace($parser['pattern'], $parser['replace'], $source);
            }
        }
        return $source;
    }

    /**
     * @param string $source String containing the BBCode
     * @return string Unparsed string
     * unparses the BBCode string
     */
    public function unparse($source)
    {
        $this->parsers = $this->unParsers;

        foreach ($this->parsers as $name => $parser) {
            $source = preg_replace($parser['pattern'], $parser['replace'], $source);
        }

        if(strlen($source) > 500) {
            $source = preg_replace('#\R+#', ' ', $source);
            $source = substr($source, 0, 497);
            $source = $source."...";
        }
        return $source;
    }

    public function helloWorld()
    {
        return 'Hello Worleed';
    }
}


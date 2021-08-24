<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MonorepoBuilder20210824\Symfony\Component\Console\Formatter;

use MonorepoBuilder20210824\Symfony\Component\Console\Exception\InvalidArgumentException;
/**
 * Formatter class for console output.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class OutputFormatter implements \MonorepoBuilder20210824\Symfony\Component\Console\Formatter\WrappableOutputFormatterInterface
{
    private $decorated;
    private $styles = [];
    private $styleStack;
    public function __clone()
    {
        $this->styleStack = clone $this->styleStack;
        foreach ($this->styles as $key => $value) {
            $this->styles[$key] = clone $value;
        }
    }
    /**
     * Escapes "<" special char in given text.
     *
     * @return string Escaped text
     * @param string $text
     */
    public static function escape($text)
    {
        $text = \preg_replace('/([^\\\\]?)</', '$1\\<', $text);
        return self::escapeTrailingBackslash($text);
    }
    /**
     * Escapes trailing "\" in given text.
     *
     * @internal
     * @param string $text
     */
    public static function escapeTrailingBackslash($text) : string
    {
        if (\substr_compare($text, '\\', -\strlen('\\')) === 0) {
            $len = \strlen($text);
            $text = \rtrim($text, '\\');
            $text = \str_replace("\0", '', $text);
            $text .= \str_repeat("\0", $len - \strlen($text));
        }
        return $text;
    }
    /**
     * Initializes console output formatter.
     *
     * @param OutputFormatterStyleInterface[] $styles Array of "name => FormatterStyle" instances
     */
    public function __construct(bool $decorated = \false, array $styles = [])
    {
        $this->decorated = $decorated;
        $this->setStyle('error', new \MonorepoBuilder20210824\Symfony\Component\Console\Formatter\OutputFormatterStyle('white', 'red'));
        $this->setStyle('info', new \MonorepoBuilder20210824\Symfony\Component\Console\Formatter\OutputFormatterStyle('green'));
        $this->setStyle('comment', new \MonorepoBuilder20210824\Symfony\Component\Console\Formatter\OutputFormatterStyle('yellow'));
        $this->setStyle('question', new \MonorepoBuilder20210824\Symfony\Component\Console\Formatter\OutputFormatterStyle('black', 'cyan'));
        foreach ($styles as $name => $style) {
            $this->setStyle($name, $style);
        }
        $this->styleStack = new \MonorepoBuilder20210824\Symfony\Component\Console\Formatter\OutputFormatterStyleStack();
    }
    /**
     * {@inheritdoc}
     * @param bool $decorated
     */
    public function setDecorated($decorated)
    {
        $this->decorated = $decorated;
    }
    /**
     * {@inheritdoc}
     */
    public function isDecorated()
    {
        return $this->decorated;
    }
    /**
     * {@inheritdoc}
     * @param string $name
     * @param \Symfony\Component\Console\Formatter\OutputFormatterStyleInterface $style
     */
    public function setStyle($name, $style)
    {
        $this->styles[\strtolower($name)] = $style;
    }
    /**
     * {@inheritdoc}
     * @param string $name
     */
    public function hasStyle($name)
    {
        return isset($this->styles[\strtolower($name)]);
    }
    /**
     * {@inheritdoc}
     * @param string $name
     */
    public function getStyle($name)
    {
        if (!$this->hasStyle($name)) {
            throw new \MonorepoBuilder20210824\Symfony\Component\Console\Exception\InvalidArgumentException(\sprintf('Undefined style: "%s".', $name));
        }
        return $this->styles[\strtolower($name)];
    }
    /**
     * {@inheritdoc}
     * @param string|null $message
     */
    public function format($message)
    {
        return $this->formatAndWrap($message, 0);
    }
    /**
     * {@inheritdoc}
     * @param string|null $message
     * @param int $width
     */
    public function formatAndWrap($message, $width)
    {
        $offset = 0;
        $output = '';
        $tagRegex = '[a-z][^<>]*+';
        $currentLineLength = 0;
        \preg_match_all("#<(({$tagRegex}) | /({$tagRegex})?)>#ix", $message, $matches, \PREG_OFFSET_CAPTURE);
        foreach ($matches[0] as $i => $match) {
            $pos = $match[1];
            $text = $match[0];
            if (0 != $pos && '\\' == $message[$pos - 1]) {
                continue;
            }
            // add the text up to the next tag
            $output .= $this->applyCurrentStyle(\substr($message, $offset, $pos - $offset), $output, $width, $currentLineLength);
            $offset = $pos + \strlen($text);
            // opening tag?
            if ($open = '/' != $text[1]) {
                $tag = $matches[1][$i][0];
            } else {
                $tag = $matches[3][$i][0] ?? '';
            }
            if (!$open && !$tag) {
                // </>
                $this->styleStack->pop();
            } elseif (null === ($style = $this->createStyleFromString($tag))) {
                $output .= $this->applyCurrentStyle($text, $output, $width, $currentLineLength);
            } elseif ($open) {
                $this->styleStack->push($style);
            } else {
                $this->styleStack->pop($style);
            }
        }
        $output .= $this->applyCurrentStyle(\substr($message, $offset), $output, $width, $currentLineLength);
        if (\strpos($output, "\0") !== \false) {
            return \strtr($output, ["\0" => '\\', '\\<' => '<']);
        }
        return \str_replace('\\<', '<', $output);
    }
    /**
     * @return OutputFormatterStyleStack
     */
    public function getStyleStack()
    {
        return $this->styleStack;
    }
    /**
     * Tries to create new style instance from string.
     */
    private function createStyleFromString(string $string) : ?\MonorepoBuilder20210824\Symfony\Component\Console\Formatter\OutputFormatterStyleInterface
    {
        if (isset($this->styles[$string])) {
            return $this->styles[$string];
        }
        if (!\preg_match_all('/([^=]+)=([^;]+)(;|$)/', $string, $matches, \PREG_SET_ORDER)) {
            return null;
        }
        $style = new \MonorepoBuilder20210824\Symfony\Component\Console\Formatter\OutputFormatterStyle();
        foreach ($matches as $match) {
            \array_shift($match);
            $match[0] = \strtolower($match[0]);
            if ('fg' == $match[0]) {
                $style->setForeground(\strtolower($match[1]));
            } elseif ('bg' == $match[0]) {
                $style->setBackground(\strtolower($match[1]));
            } elseif ('href' === $match[0]) {
                $style->setHref($match[1]);
            } elseif ('options' === $match[0]) {
                \preg_match_all('([^,;]+)', \strtolower($match[1]), $options);
                $options = \array_shift($options);
                foreach ($options as $option) {
                    $style->setOption($option);
                }
            } else {
                return null;
            }
        }
        return $style;
    }
    /**
     * Applies current style from stack to text, if must be applied.
     */
    private function applyCurrentStyle(string $text, string $current, int $width, int &$currentLineLength) : string
    {
        if ('' === $text) {
            return '';
        }
        if (!$width) {
            return $this->isDecorated() ? $this->styleStack->getCurrent()->apply($text) : $text;
        }
        if (!$currentLineLength && '' !== $current) {
            $text = \ltrim($text);
        }
        if ($currentLineLength) {
            $prefix = \substr($text, 0, $i = $width - $currentLineLength) . "\n";
            $text = \substr($text, $i);
        } else {
            $prefix = '';
        }
        \preg_match('~(\\n)$~', $text, $matches);
        $text = $prefix . \preg_replace('~([^\\n]{' . $width . '})\\ *~', "\$1\n", $text);
        $text = \rtrim($text, "\n") . ($matches[1] ?? '');
        if (!$currentLineLength && '' !== $current && "\n" !== \substr($current, -1)) {
            $text = "\n" . $text;
        }
        $lines = \explode("\n", $text);
        foreach ($lines as $line) {
            $currentLineLength += \strlen($line);
            if ($width <= $currentLineLength) {
                $currentLineLength = 0;
            }
        }
        if ($this->isDecorated()) {
            foreach ($lines as $i => $line) {
                $lines[$i] = $this->styleStack->getCurrent()->apply($line);
            }
        }
        return \implode("\n", $lines);
    }
}

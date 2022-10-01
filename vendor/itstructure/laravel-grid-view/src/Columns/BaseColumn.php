<?php

namespace Itstructure\GridView\Columns;

use Exception;
use Itstructure\GridView\Filters\BaseFilter;
use Itstructure\GridView\Filters\StubFilter;
use Itstructure\GridView\Filters\TextFilter;
use Itstructure\GridView\Formatters\HtmlFormatter;
use Itstructure\GridView\Formatters\ImageFormatter;
use Itstructure\GridView\Formatters\TextFormatter;
use Itstructure\GridView\Formatters\UrlFormatter;
use Itstructure\GridView\Interfaces\Formattable;
use Itstructure\GridView\Traits\Attributable;
use Itstructure\GridView\Traits\Configurable;

/**
 * Class BaseColumn
 * @package Itstructure\GridView\Columns
 */
abstract class BaseColumn
{
    use Configurable, Attributable;

    const
    FORMATTER_HTML = 'html',
    FORMATTER_IMAGE = 'image',
    FORMATTER_TEXT = 'text',
    FORMATTER_URL = 'url',

    FORMATTER_DEFINITIONS = [
        self::FORMATTER_HTML => HtmlFormatter::class,
        self::FORMATTER_IMAGE => ImageFormatter::class,
        self::FORMATTER_TEXT => TextFormatter::class,
        self::FORMATTER_URL => UrlFormatter::class,
    ];

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $attribute;

    /**
     * @var bool|null|string
     */
    protected $sort;

    /**
     * @var string $value
     */
    protected $value;

    /**
     * @var bool|null|string|BaseFilter
     */
    protected $filter;

    /**
     * @var string|Formattable
     */
    protected $format;

    /**
     * @var bool
     */
    protected $inlineEdit;

    /**
     * @var string
     */
    protected $inlineEditBox;
    /**
     * BaseColumn constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->loadConfig($config);
        $this->buildFilter();
        $this->buildFormatter();
    }

    /**
     * @param $row
     * @return mixed
     */
    function getValue($row)
    {
    }

    /**
     * Render row attribute value.
     * @param $row
     * @return mixed
     */
    function render($row)
    {
        return $this->formatTo($this->getValue($row));
    }

    /**
     * Format value with formatter.
     * @param $value
     * @return mixed
     */
    function formatTo($value)
    {
        return $this->format->format($value);
    }

    /**
     * Get title for grid head.
     * @return string
     */
    function getLabel(): string
    {
        return $this->label ?? ucwords(str_replace("_", " ", $this->attribute));
    }

    /**
     * Get attribute.
     * @return string|null
     */
    function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @return bool|null|string
     */
    function getSort()
    {
        if (is_null($this->sort) || $this->sort === true) {
            return is_null($this->attribute) ? false : $this->attribute;
        }
        return $this->sort;
    }

    /**
     * @return BaseFilter
     */
    function getFilter()
    {
        return $this->filter;
    }

    /**
     * @return bool
     */
    function getInlineEdit()
    {
        if (is_null($this->inlineEdit) || $this->inlineEdit === true) {
            return is_null($this->inlineEdit) ? false : true;
        }
        return $this->inlineEdit;
    }

    /**
     * @return string
     */
    function getInlineEditBox()
    {
        return $this->inlineEditBox ? $this->inlineEditBox : [];
    }

    /**
     * @param BaseFilter $filter
     */
    function setFilter(BaseFilter $filter): void
    {
        $this->filter = $filter;
    }

    /**
     * @return void
     */
    function buildFilter(): void
    {
        if ($this->filter === false) {
            $this->filter = new StubFilter();

        } else if (is_null($this->filter)) {
            $this->filter = new TextFilter([
                'name' => $this->getAttribute(),
            ]);

        } else if (is_array($this->filter)) {
            if (isset($this->filter['class']) && class_exists($this->filter['class'])) {
                $this->setFilter(
                    new $this->filter['class'](array_merge($this->filter, empty($this->filter['name']) ? [
                        'name' => $this->getAttribute(),
                    ] : [])
                    )
                );
            }
        }
    }

    /**
     * @param Formattable $formatter
     */
    function setFormatter(Formattable $formatter): void
    {
        $this->format = $formatter;
    }

    /**
     * @throws Exception
     * @return void
     */
    function buildFormatter(): void
    {
        if (is_null($this->format)) {
            $class = self::FORMATTER_DEFINITIONS[self::FORMATTER_TEXT];
            $this->format = new $class;

        } else if (is_string($this->format)) {
            $class = self::FORMATTER_DEFINITIONS[$this->format] ?? self::FORMATTER_DEFINITIONS[self::FORMATTER_TEXT];
            $this->format = new $class;

        } else if (is_array($this->format)) {
            if (isset($this->format['class']) && class_exists($this->format['class'])) {
                $this->setFormatter(new $this->format['class']($this->format));
            }

        } else if (!is_object($this->format) || !($this->format instanceof Formattable)) {
            throw new Exception('Incorrect formatter.');
        }
    }
}
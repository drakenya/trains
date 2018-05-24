<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 5/15/18
 * Time: 12:57 PM
 */

namespace App\Paperwork\Page;


class FullEmptyCarBillPage
{
    private const PAGE_WIDTH = 8.5;
    private const PAGE_HEIGHT = 11;

    private const WIDTH = 2.5;
    private const HEIGHT = 3.5;

    private const PAGE_ROWS = 3;
    private const PAGE_COLUMNS = 3;

    private const PAGE_MARGIN_TOP = 0.25;
    private const PAGE_MARGIN_SIDE = 0.5;

    public function getPageWidth(): float
    {
        return static::PAGE_WIDTH;
    }

    public function getPageHeight(): float
    {
        return static::PAGE_HEIGHT;
    }

    public function getPageRows(): int
    {
        return static::PAGE_ROWS;
    }

    public function getPageColumns(): int
    {
        return static::PAGE_COLUMNS;
    }

    public function getPageTopMargin(): float
    {
        return static::PAGE_MARGIN_TOP;
    }

    public function getPageSideMargin(): float
    {
        return static::PAGE_MARGIN_SIDE;
    }

    public function getItemWidth(): float
    {
        return static::WIDTH;
    }

    public function getItemHeight(): float
    {
        return static::HEIGHT;
    }
}
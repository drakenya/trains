<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/6/18
 * Time: 3:28 PM
 */

namespace App\Paperwork\Page;


final class LabelSheet
{
    const WIDTH = 8.5;
    const HEIGHT = 11;

    const MARGIN_TOP = 0.5;
    const MARGIN_SIDE = 3/16;

    const COLUMN_BUFFER = 0.125;

    const ROWS = 10;
    const COLUMNS = 3;
}
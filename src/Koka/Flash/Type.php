<?php

namespace Koka\Flash;

/**
 * Class Type
 * @package Koka\Flash
 */
abstract class Type
{

    /**
     * @const
     */
    const ERROR = 10;

    /**
     * @const
     */
    const WARNING = 20;

    /**
     * @const
     */
    const NOTICE = 30;

    /**
     * @const
     */
    const INFO = 40;

    /**
     * @const
     */
    const SUCCESS = 50;
}

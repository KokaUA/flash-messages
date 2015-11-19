<?php

namespace Koka\Flash;

/**
 * Interface FlashInterface
 * @package Koka\Flash
 */
interface FlashInterface
{
    /**
     * @param  int|array $type
     * @return array
     */
    public function pop($type);

    /**
     * @return bool
     */
    public function has();

    /**
     * @param  string $message
     * @return $this
     */
    public function error($message);

    /**
     * @param  string $message
     * @return $this
     */
    public function danger($message);

    /**
     * @param  string $message
     * @return $this
     */
    public function warning($message);

    /**
     * @param  string $message
     * @return $this
     */
    public function notice($message);

    /**
     * @param  string $message
     * @return $this
     */
    public function alert($message);

    /**
     * @param  string $message
     * @return $this
     */
    public function info($message);

    /**
     * @param  string $message
     * @return $this
     */
    public function success($message);
}

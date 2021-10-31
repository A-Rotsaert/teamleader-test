<?php

declare(strict_types=1);

namespace App\Router;

/**
 * Request
 *
 * @author <andy.rotsaert@live.be>
 */
final class Request
{
    /**
     * @return string
     */
    public function get(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * @param string|null $key
     * @return mixed
     */
    public function post(?string $key = null): mixed
    {
        $data = json_decode(file_get_contents('php://input'), true);
        return (isset($key)) ? $data[$key] : $data;
    }
}

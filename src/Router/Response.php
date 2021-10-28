<?php

declare(strict_types=1);

namespace App\Router;

/**
 * Router response
 *
 * @todo implement other response output formats (eg. XML, CSV, JSON-LD, HTML, XLS/XLSX)
 * @author <andy.rotsaert@live.be>
 */
final class Response
{
    /**
     * @var int|mixed
     */
    private int $responseCode;

    /**
     * Create a new Response
     *
     * @param int $responseCode
     * @param mixed|array $data
     * @param string $outputFormat
     */
    public function __construct(int $responseCode = 200, mixed $data = [], string $outputFormat = 'json')
    {
        $this->responseCode = $responseCode;
        switch ($outputFormat) {
            default:
            case 'json':
                $this->outputAsJSON($data);
                break;
        }
    }

    /**
     * @param mixed $data
     *
     * @todo: fix headers already sent
     */
    private function outputAsJSON(mixed $data)
    {
        http_response_code($this->responseCode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}

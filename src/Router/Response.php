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
            case 'html':
                echo $data;
                break;
            case 'html-md':
                $this->processMarkdown($data);
                break;
            default:
            case 'json':
                $this->outputAsJSON($data);
                break;
        }
    }

    private function processMarkdown(mixed $data): void
    {
        http_response_code($this->responseCode);
        header('Content-Type: text/html ');
        $html =
            /** @lang HTML */
            <<<EOD
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>Welcome</title>
                <link rel="stylesheet" href="css/markdown.css">
            </head>
            <body>
                $data
            </body>
            </html>
        EOD;

        echo $html;
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

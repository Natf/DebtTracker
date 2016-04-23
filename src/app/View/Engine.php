<?php

namespace Nat\DebtTracker\View;

use Psr\Http\Message\ResponseInterface;

class Engine extends \League\Plates\Engine
{
    public function render($name, array $data = [], ResponseInterface $response = null)
    {
        $output = parent::render($name, $data);

        if (is_null($response)) {
            return $output;
        }
        
        $response->getBody()->write($output);

        return $response;
    }
}
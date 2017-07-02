<?php

namespace Nat\DebtTracker\View;

use Psr\Http\Message\ResponseInterface;

class Engine extends \League\Plates\Engine
{
    public function render($name, array $data = [], ResponseInterface $response = null)
    {
        $output = parent::render($name, $data);
//        die('here');

//        var_dump($output); die;

        if (is_null($response)) {
            return $output;
        }

//        var_dump($output); die;
        
        $response->getBody()->write($output);

        return $response;
    }
}
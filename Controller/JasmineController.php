<?php

namespace Havvg\Bundle\JasmineBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

class JasmineController
{
    protected $templating;
    protected $template;

    public function __construct(EngineInterface $templating, $template)
    {
        $this->templating = $templating;
        $this->template = $template;
    }

    public function testAction()
    {
        return new Response($this->templating->render($this->template));
    }
}

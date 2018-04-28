<?php

namespace dominx99\school\Controllers;

use Slim\Http\Response;

/**
 * @property object $view
 */
class DocsController extends Controller
{
    public function index()
    {
        return $this->view->render(new Response(), 'docs/docs.twig');
    }
}

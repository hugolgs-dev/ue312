<<<<<<< HEAD
<?php declare(strict_types=1);

namespace Framework312\Router\View;

use Framework312\Router\Exception as RouterException;
use Framework312\Router\Request;
use Symfony\Component\HttpFoundation\Response;
=======
<?php

namespace Framework312\Router\View;

use Framework312\Router\Request;
use Framework312\Router\View\BaseView;
use Symfony\Component\HttpFoundation\Response;

class TemplateView extends BaseView
{

    static public function use_template(): bool
    {
        // TODO: Implement use_template() method.
    }

    public function render(Request $request): Response
    {
        // TODO: Implement render() method.

    }
}
>>>>>>> 083d0bc0bff4052680f242d7f3908543fe4466f0

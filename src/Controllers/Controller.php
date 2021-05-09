<?php


namespace Controllers;


use Laminas\Diactoros\Response;
use Utility\Auth;
use Utility\Session;

class Controller
{
    /**
     * @var \Twig\Environment $templateEngine
     */
    private $templateEngine;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../View');
        $twig = new \Twig\Environment($loader);
        $twig->addGlobal('authenticated', Auth::isAuthenticated());
        if (Session::exists('message')) {
            $twig->addGlobal('message', Session::get('message'));
            Session::delete('message');
        }
        $this->templateEngine = $twig;
    }

    protected function render(string $page, array $data = array()): Response
    {
        $response = new Response();
        $response->getBody()->write($this->templateEngine->render($page, $data));
        return $response;
    }

    public function redirect(string $uri, int $statusCode = 302)
    {
        $response = new Response();
        return $response->withHeader('Location', $uri)->withStatus($statusCode);
    }

    public function authorized()
    {
        if (Auth::isUnauthenticated())
            return $this->redirect('/login');
        return null;
    }

    public function anonymous()
    {
        if (Auth::isAuthenticated())
            return $this->redirect('/');
        return null;
    }

    public function error404(): Response
    {
        $response = new Response();
        return $response->withStatus(404);
    }
}
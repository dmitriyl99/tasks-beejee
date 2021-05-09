<?php


namespace Controllers;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Utility\Auth;
use Utility\Session;

class LoginController extends Controller
{
    public function showLoginPage(): ResponseInterface
    {
        if (! is_null($response = $this->anonymous()))
            return $response;

        $errors = [];
        if (Session::exists('errors'))
            $errors = Session::get('errors');
        Session::delete('errors');

        return $this->render('login.twig', ['errors' => $errors]);
    }

    public function login(ServerRequestInterface $request): ResponseInterface
    {
        if (! is_null($response = $this->anonymous()))
            return $response;

        $credentials = $request->getParsedBody();
        try {
            Auth::login($credentials);
        } catch (\Exception $e) {
            $errors = [];
            if (Session::exists('errors')) {
                $errors = Session::get('errors');
            }
            $errors[] = $e->getMessage();
            Session::put('errors', $errors);

            return $this->redirect('/login');
        }

        return $this->redirect('/');
    }

    public function logout()
    {
        if (! is_null($response = $this->authorized()))
            return $response;

        Session::destroy();
        return $this->redirect('/');
    }
}
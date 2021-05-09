<?php


namespace Controllers;

use Managers\TaskManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Utility\Paginator;
use Utility\Session;

class TaskController extends Controller
{
    /** @var \Managers\TaskManager */
    private TaskManager $taskManager;

    public function __construct()
    {
        parent::__construct();
        $this->taskManager = new TaskManager(); // Imagine that there is a dependency injection here
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $sorting = [
            'userName' => $queryParams['sort_name'] ?? null,
            'email' => $queryParams['sort_email'] ?? null,
            'status' => $queryParams['sort_status'] ?? null,
        ];

        $page = isset($queryParams['page']) ? (int)$queryParams['page'] : 1;
        unset($queryParams['page']); // unset page parameter to avoid duplicates
        $totalTasks = $this->taskManager->countAll();
        $paginator = new Paginator($page, $totalTasks, 3, http_build_query($queryParams));
        Session::put('page', $page);

        $tasks = $this->taskManager->getAll($sorting, $paginator->start, $paginator->perPage);
        return $this->render('tasks/index.twig', ['tasks' => $tasks, 'sorting' => $sorting, 'paginator' => $paginator]);
    }

    public function create(): ResponseInterface
    {
        return $this->render('tasks/create.twig');
    }

    public function store(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();
        $this->taskManager->create($data['userName'], $data['email'], $data['text']);
        Session::put('message', 'Задача успешно добавлена');
        return $this->redirect('/');
    }

    public function edit(ServerRequestInterface $request, array $args): ResponseInterface
    {
        if (! is_null($response = $this->authorized()))
            return $response;

        $id = $args['id'];
        $task = $this->taskManager->getById($id);
        if ($task == null) {
            return $this->error404();
        }
        return $this->render('tasks/edit.twig', ['task' => $task]);
    }

    public function update(ServerRequestInterface $request, array $args): ResponseInterface
    {
        if (! is_null($response = $this->authorized()))
            return $response;

        $data = $request->getParsedBody();
        $task = $this->taskManager->update($args['id'], $data['userName'], $data['email'], $data['text']);
        if (is_null($task)) return $this->error404();

        $page = 1;
        if (Session::exists('page'))
            $page = Session::get('page');

        Session::put('message', 'Задача изменена');
        return $this->redirect('/?page='.$page);
    }

    public function done(ServerRequestInterface $request, array $args): ResponseInterface
    {
        if (! is_null($response = $this->authorized()))
            return $response;

        $task = $this->taskManager->makeDone($args['id']);
        if (is_null($task)) return $this->error404();

        $page = 1;
        if (Session::exists('page'))
            $page = Session::get('page');

        return $this->redirect('/?page='.$page);
    }
}
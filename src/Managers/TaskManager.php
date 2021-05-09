<?php


namespace Managers;


use Doctrine\ORM\QueryBuilder;
use Models\Task;

class TaskManager extends DatabaseManager
{
    public function getAll(array $sorting = array(), $firstResult = 0, $maxResult = 3): array
    {
        $queryBuilder = $this->getRepository(Task::class)->createQueryBuilder('t');

        if (!empty($sorting))
            $this->sortedQueryBuilder($queryBuilder, $sorting);

        $queryBuilder->setFirstResult($firstResult)->setMaxResults($maxResult);
        return $queryBuilder->getQuery()->getResult();
    }

    public function countAll(): int
    {
        $queryBuilder = $this->getRepository(Task::class)->createQueryBuilder('t');
        return (int)$queryBuilder->select('COUNT(t.id)')->getQuery()->getScalarResult()[0][1];
    }

    public function create(string $userName, string $email, string $text): Task
    {
        $task = new Task();
        $task->setUserName($userName);
        $task->setEmail($email);
        $task->setText($text);

        $this->createEntity($task);

        return $task;
    }

    public function getById($id): ?object
    {
        $id = (int)$id;
        return $this->getRepository(Task::class)->find($id);
    }

    public function update($id, string $userName, string $email, string $text): ?Task
    {
        $id = (int)$id;
        /** @var Task $task */
        $task = $this->getById($id);
        if (is_null($task)) return null;
        $task->setUserName($userName);
        $task->setEmail($email);
        if ($task->getText() != $text)
            $task->setModified();
        $task->setText($text);

        $this->flush($task);

        return $task;
    }

    public function makeDone($id): ?Task
    {
        $id = (int)$id;
        /** @var Task $task */
        $task = $this->getById($id);
        if (is_null($task)) return null;

        $task->setDone();

        $this->createEntity($task);

        return $task;
    }

    private function sortedQueryBuilder(QueryBuilder $queryBuilder, array $sorting)
    {
        $orders = ['desc', 'asc'];
        if (!empty($sorting['userName']) and in_array($sorting['userName'], $orders))
            $queryBuilder->orderBy('t.userName', $sorting['userName']);
        if (!empty($sorting['email']) and in_array($sorting['email'], $orders))
            $queryBuilder->addOrderBy('t.email', $sorting['email']);
        if (!empty($sorting['status']) and in_array($sorting['status'], $orders))
            $queryBuilder->addOrderBy('t.done', $sorting['status']);
    }
}
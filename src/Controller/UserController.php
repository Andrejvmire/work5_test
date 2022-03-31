<?php

namespace App\Controller;

use App\Container;
use App\Model\User;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Список пользователей
     * @return Response
     */
    public function indexAction(): Response
    {
        $db = Container::getDb();
        try {
            $qb = (new User($db))->select(['name', 'full_name', 'email', 'id']);
            $result = $qb->executeQuery();
            $result = $result->fetchAllAssociative();
        } catch (\Exception $e) {
            // в логгер
        }
        return $this->renderTwig('list.users.html.twig', [
            'users' => $result ?? [],
            'href' => '/user/edit/',
        ]);
    }

    /**
     * Вывод и обработка формы регистрации
     * @return Response
     */
    public function registrationAction(): Response
    {
        $request = Container::getRequest();
        if ($request->isMethod("POST")) {
            $db = Container::getDb();
            $user = new User($db);
            $value = $request->request->all();
            // пароль лучше захешировать)
            try {
                $user->insertValue($value)->executeStatement();
            } catch (Exception $e) {
                // в логгер
            }
            return $this->redirectToRoute('/user/');
        };
        return $this->renderTwig('registration.html.twig', [
            "data" => $request->request->all(),
        ]);
    }

    /**
     * Редактирование данных
     * @param array $params
     * @return Response
     */
    public function editAction(array $params): Response
    {
        $id = $params['id'] ?? null;
        if (is_null($id)) {
            return $this->redirectToRoute('/');
        }
        $request = Container::getRequest();
        $db = Container::getDb();
        $user = new User($db);
        if ($request->isMethod('POST')) {
            try {
                $user->updateValue($request->request->all(), ['=', 'id', $id])->executeStatement();
            } catch (Exception $e) {
                // в логгер
            }
            return $this->redirectToRoute('/user/');
        }
        $result = $user->select(['full_name'], "id = $id")->fetchAssociative();
        return $this->renderTwig('edit.html.twig', [
            "data" => $result
        ]);
    }

}
<?php

namespace Engine\Controller\Admin;

use Engine\Entity\User;
use Engine\Form\Admin\Users\SearchForm;
use Engine\Form\Admin\Users\AddForm;
use Engine\Form\Admin\Users\EditForm;
use Engine\Controller\Base\AdminController;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class UsersController extends AdminController
{
    public function indexAction()
    {

    }
    public function listAction()
    {
        $repository = $this->getEntityManager()->getRepository(User::class);

        $searchForm = new SearchForm();
        $params = $this->params()->fromQuery();

        $users = $repository->findAll();

        if (!empty($params)) {

            $searchForm->setData($params);
            $users = $repository->findByParams($params);
        }

        //Подключаем paginator для вывода страниц
        $adapter = new DoctrineAdapter(new ORMPaginator($users));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);
        $paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
        return [
            'searchForm' => $searchForm,
            'userList' => $paginator,
            'query' => $params
        ];
    }

    public function addAction()
    {
        return ['form' => new AddForm($this->getEntityManager()->getRepository(User::class), $this->user)];
    }
}

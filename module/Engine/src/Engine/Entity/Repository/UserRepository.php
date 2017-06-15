<?php

namespace Engine\Entity\Repository;

use Engine\Entity\User;
use Doctrine\ORM\EntityRepository;
use Zend\Authentication\AuthenticationService;

class UserRepository extends EntityRepository
{
    public function login (User $user , $sm)
    {
        $authService = $sm->get(AuthenticationService::class);
        $adapter = $authService->getAdapter();
        $adapter->setIdentity($user->getLogin());
        $adapter->setCredential($user->getPassword());
        $authResult = $authService->authenticate();
        $identity = null;

        if ($authResult->isValid()) {
            $identity = $authResult->getIdentity();
            $authService->getStorage()->write($identity);
        }

        return $authResult;
    }

    public function add (User $user)
    {
        $em = $this->getEntityManager();
        $user->setPassword(UserRepository::passwordTransform($user->getPassword()));
        if (empty($user->getType())) $user->setType($this->checkCreateAdminUserIfNotExists($this) ? 0 : 2);
        $em->persist($user);
        $em->flush();
    }

    public function remove($id)
    {
        $em = $this->getEntityManager();
        $user = $this->findOneBy([
            'id' => $id
        ]);
        $em->remove($user);
        $em->flush();
    }

    public function changePassword (User $user)
    {
        $user->setPassword(UserRepository::passwordTransform($user->getPassword()));
        $em = $this->getEntityManager();
        $em->flush();
    }

    public function isValidAuthData (User $user)
    {
        $user = $this->findOneBy([
            'login' => $user->getLogin(),
            'password' => UserRepository::passwordTransform($user->getPassword())
        ]);
        return $user == null ? false : true;
    }
    public function findEntityByParams ($params)
    {
        $user = $this->findOneBy($params);
        return $user;
    }
    public function findAll()
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder
            ->select('u')
            ->from(User::class, 'u')
            ->orderBy('u.id', 'ASC');

        return $queryBuilder->getQuery();
    }
    public function findByParams($params)
    {
        if (empty($params))
            return null;

        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder = $queryBuilder->select('u')->from(User::class, 'u')->where('u.id = u.id');
        if (!empty($params['id'])) $queryBuilder = $queryBuilder->andWhere('u.id = '. $params['id']);
        if (!empty($params['login'])) $queryBuilder = $queryBuilder->andWhere("u.login LIKE '%". $params['login'] ."%'");
        if (!empty($params['type'])) {
            if (in_array('', $params['type'])) {
                $queryBuilder = $queryBuilder->andWhere('u.type = u.type ');
            }
            else {
                $queryBuilder = $queryBuilder->andWhere('u.type IN (:types)')->setParameter('types', array_filter($params['type'], function($k) {
                    return is_int($k);
                }, ARRAY_FILTER_USE_KEY));
            }
        }
        $queryBuilder = $queryBuilder->orderBy('u.id', 'ASC');

        return $queryBuilder->getQuery();
    }

    /**
     * Transform clear-text password
     *
     * @param string $password
     *
     * @return string
     */
    public static function passwordTransform($password)
    {
        return sha1('SALT' . sha1($password));
    }

    /**
     * Authentication condition
     *
     * @param User $user
     * @param string $credential
     *
     * @return bool result
     */
    public static function authCondition(User $user, $credential)
    {
        if($user->getPassword() == UserRepository::passwordTransform($credential))
            return true;
        else
            return false;

    }
    private function checkCreateAdminUserIfNotExists()
    {
        $user = $this->findOneBy([]);
        return $user != null ? false : true;
    }
}

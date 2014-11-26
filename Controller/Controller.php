<?php

namespace CelciusTech\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class Controller extends BaseController
{
    /**
     * Get currently logged in user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->get('security.context')->getToken()->getUser();
    }

    /**
     * Get doctrine manager
     *
     * @param string connection
     *
     * @return EntityManager
     */
    public function getManager($connection = 'default')
    {
        return $this->getDoctrine()->getManager($connection);
    }

    /**
     * Get repository
     *
     * @param string repository name (BundleName:RepoName)
     * @param string connection
     *
     * @return EntityRepository
     */
    public function getRepository($repo, $connection = 'default')
    {
        return $this->getManager($connection)->getRepository($repo);
    }

    /**
     * Get session
     *
     * @return Session
     */
    public function getSession()
    {
        return $this->getRequest()->getSession();
    }

    /**
     * Get container parameter
     *
     * @param string parameter key
     *
     * @return string parameter value
     */
    public function getParameter($key)
    {
        return $this->container->getParameter($key);
    }

    /**
     * Add flash
     *
     * @param string flash key
     * @param string flash value
     */
    public function addFlash($key, $value)
    {
        $this->getSession()->getFlashBag()->add($key, $value);
    }

    /**
     * Translate a message
     *
     * @param string keyword|word
     * @param array replacements
     *
     * @return string translated message
     */
    public function translate($keyword, $replacements = array())
    {
        return $this->get('translator')->trans($keyword, $replacements);
    }

    /**
     * Get doctrine paginator
     *
     * @param QueryBuilder|Query
     * @param integer $maxPerPage
     * @param integer $currentPage
     *
     * @return Pagerfanta
     */
    public function getDoctrinePaginator($query, $maxPerPage = 10, $currentPage = null)
    {
        $adapter = new DoctrineORMAdapter($query);
        $paginator = new Pagerfanta($adapter);
        $paginator->setMaxPerPage($maxPerPage);
        if ($currentPage) {
            $paginator->setCurrentPage($currentPage);
        } else {
            $paginator->setCurrentPage($this->getRequest()->query->get('page') ?: 1);
        }

        return $paginator;
    }

    /**
     * Returns response as JSON
     *
     * @return mixed $data
     * @return JsonResponse
     */
    public function renderJson($data)
    {
        return new JsonResponse($data);
    }
}

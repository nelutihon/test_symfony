<?php

namespace Nelu\CatalogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Empty controller.
 *
 * @Route("/")
 */
class EmptyController extends Controller {

    /**
     * @Route("/", name="empty")
     * @Method("GET")
     */
    public function indexAction() {

        return $this->redirect( $this->generateUrl( 'catalog_category' ) );
    }

    public function __toString() {
        return 'nelu_catalog_empty';
    }

}

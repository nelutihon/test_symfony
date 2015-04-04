<?php

namespace Nelu\CatalogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Nelu\CatalogBundle\Entity\Product;
use Nelu\CatalogBundle\Form\ProductType;

/**
 * Product controller.
 *
 * @Route("/product")
 */
class ProductController extends Controller {

    /**
     * Lists all Product entities.
     *
     * @Route("/", name="catalog_product")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository( 'NeluCatalogBundle:Product' )->findAll();
        
        $deleteForms = array();
        foreach ( $entities as $entity ) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm( $entity->getId() )->createView();
        }
        
        return array(
            'entities' => $entities,
            'deleteForms' => $deleteForms,
        );
    }

    /**
     * Creates a new Product entity.
     *
     * @Route("/", name="catalog_product_create")
     * @Method("POST")
     * @Template("NeluCatalogBundle:Product:new.html.twig")
     */
    public function createAction( Request $request ) {
        $entity = new Product();
        $form = $this->createCreateForm( $entity );
        $form->handleRequest( $request );

        if ( $form->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist( $entity );
            $em->flush();

            if ($form->get('save_and_close')->isClicked()) {
                return $this->redirect( $this->generateUrl( 'catalog_product' ) );
            }
            
            return $this->redirect( $this->generateUrl( 'catalog_product_edit', array( 'id' => $entity->getId() ) ) );
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Product entity.
     *
     * @param Product $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm( Product $entity ) {
        $form = $this->createForm( new ProductType(), $entity, array(
            'action' => $this->generateUrl( 'catalog_product_create' ),
            'method' => 'POST',
                ) );

        return $form;
    }

    /**
     * Displays a form to create a new Product entity.
     *
     * @Route("/new", name="catalog_product_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Product();
        $form = $this->createCreateForm( $entity );

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Product entity.
     *
     * @Route("/{id}", name="catalog_product_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction( $id ) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository( 'NeluCatalogBundle:Product' )->find( $id );

        if ( ! $entity ) {
            throw $this->createNotFoundException( 'Unable to find Product entity.' );
        }

        $deleteForm = $this->createDeleteForm( $id );

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     * @Route("/{id}/edit", name="catalog_product_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction( $id ) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository( 'NeluCatalogBundle:Product' )->find( $id );

        if ( ! $entity ) {
            throw $this->createNotFoundException( 'Unable to find Product entity.' );
        }

        $editForm = $this->createEditForm( $entity );
        $deleteForm = $this->createDeleteForm( $id );

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Product entity.
     *
     * @param Product $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm( Product $entity ) {
        $form = $this->createForm( new ProductType(), $entity, array(
            'action' => $this->generateUrl( 'catalog_product_update', array( 'id' => $entity->getId() ) ),
            'method' => 'PUT',
                ) );

        return $form;
    }

    /**
     * Edits an existing Product entity.
     *
     * @Route("/{id}", name="catalog_product_update")
     * @Method("PUT")
     * @Template("NeluCatalogBundle:Product:edit.html.twig")
     */
    public function updateAction( Request $request, $id ) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository( 'NeluCatalogBundle:Product' )->find( $id );

        if ( ! $entity ) {
            throw $this->createNotFoundException( 'Unable to find Product entity.' );
        }

        $deleteForm = $this->createDeleteForm( $id );
        $editForm = $this->createEditForm( $entity );
        $editForm->handleRequest( $request );

        if ( $editForm->isValid() ) {
            $em->flush();

            if ($editForm->get('save_and_close')->isClicked()) {
                return $this->redirect( $this->generateUrl( 'catalog_product' ) );
            }
            
            return $this->redirect( $this->generateUrl( 'catalog_product_edit', array( 'id' => $id ) ) );
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Product entity.
     *
     * @Route("/{id}", name="catalog_product_delete")
     * @Method("DELETE")
     */
    public function deleteAction( Request $request, $id ) {
        $form = $this->createDeleteForm( $id );
        $form->handleRequest( $request );

        if ( $form->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository( 'NeluCatalogBundle:Product' )->find( $id );

            if ( ! $entity ) {
                throw $this->createNotFoundException( 'Unable to find Product entity.' );
            }
            $em->remove( $entity );
            $em->flush();
            return new Response( json_encode( array( 'responseCode' => 200, 'success' => true ) ), 200 );
        }
        
        return new Response( json_encode(array( 'responseCode' => 500 )), 500 );
    }

    /**
     * Creates a form to delete a Product entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm( $id ) {
        return $this->createFormBuilder()
                        ->setAction( $this->generateUrl( 'catalog_product_delete', array( 'id' => $id ) ) )
                        ->setMethod( 'DELETE' )
                        ->add( 'submit', 'submit', array( 'label' => 'Delete' ) )
                        ->getForm()
        ;
    }

    public function __toString() {
        return (string) $this->getName();
    }

}

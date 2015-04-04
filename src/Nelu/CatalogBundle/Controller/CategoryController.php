<?php

namespace Nelu\CatalogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


use Nelu\CatalogBundle\Entity\Category;
use Nelu\CatalogBundle\Form\CategoryType;

/**
 * Category controller.
 *
 * @Route("/category")
 */
class CategoryController extends Controller {

    /**
     * Lists all Category entities.
     *
     * @Route("/", name="catalog_category")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository( 'NeluCatalogBundle:Category' )->findAll();

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
     * Creates a new Category entity.
     *
     * @Route("/", name="catalog_category_create")
     * @Method("POST")
     * @Template("NeluCatalogBundle:Category:new.html.twig")
     */
    public function createAction( Request $request ) {
        $entity = new Category();
        $form = $this->createCreateForm( $entity );
        $form->handleRequest( $request );

        if ( $form->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist( $entity );
            $em->flush();
            if ($form->get('save_and_close')->isClicked()) {
                return $this->redirect( $this->generateUrl( 'catalog_category' ) );
            }
            return $this->redirect( $this->generateUrl( 'catalog_category_edit', array( 'id' => $entity->getId() ) ) );
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Category entity.
     *
     * @param Category $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm( Category $entity ) {
        $form = $this->createForm( new CategoryType(), $entity, array(
            'action' => $this->generateUrl( 'catalog_category_create' ),
            'method' => 'POST',
                ) );

        return $form;
    }

    /**
     * Displays a form to create a new Category entity.
     *
     * @Route("/new", name="catalog_category_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Category();
        $form = $this->createCreateForm( $entity );

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/{id}", name="catalog_category_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction( $id ) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository( 'NeluCatalogBundle:Category' )->find( $id );

        if ( ! $entity ) {
            throw $this->createNotFoundException( 'Unable to find Category entity.' );
        }

        $deleteForm = $this->createDeleteForm( $id );

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="catalog_category_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction( $id ) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository( 'NeluCatalogBundle:Category' )->find( $id );

        if ( ! $entity ) {
            throw $this->createNotFoundException( 'Unable to find Category entity.' );
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
     * Creates a form to edit a Category entity.
     *
     * @param Category $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm( Category $entity ) {
        $form = $this->createForm( new CategoryType(), $entity, array(
            'action' => $this->generateUrl( 'catalog_category_update', array( 'id' => $entity->getId() ) ),
            'method' => 'PUT',
                ) );

        return $form;
    }

    /**
     * Edits an existing Category entity.
     *
     * @Route("/{id}", name="catalog_category_update")
     * @Method("PUT")
     * @Template("NeluCatalogBundle:Category:edit.html.twig")
     */
    public function updateAction( Request $request, $id ) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository( 'NeluCatalogBundle:Category' )->find( $id );

        if ( ! $entity ) {
            throw $this->createNotFoundException( 'Unable to find Category entity.' );
        }

        $deleteForm = $this->createDeleteForm( $id );
        $editForm = $this->createEditForm( $entity );
        $editForm->handleRequest( $request );

        if ( $editForm->isValid() ) {            
            $em->flush();
            if ($editForm->get('save_and_close')->isClicked()) {
                return $this->redirect( $this->generateUrl( 'catalog_category' ) );
            }
            return $this->redirect( $this->generateUrl( 'catalog_category_edit', array( 'id' => $id ) ) );
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}/delete", name="catalog_category_delete")
     * @Method("DELETE")
     */
    public function deleteAction( Request $request, $id ) {
        $form = $this->createDeleteForm( $id );
        $form->handleRequest( $request );

        if ( $form->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository( 'NeluCatalogBundle:Category' )->find( $id );

            if ( ! $entity ) {
                throw $this->createNotFoundException( 'Unable to find Category entity.' );
            }

            $em->remove( $entity );
            $em->flush();

            return new Response( json_encode( array( 'responseCode' => 200, 'success' => true ) ), 200 );
        }
        
        return new Response( json_encode(array( 'responseCode' => 500 )), 500 );
    }

    /**
     * Creates a form to delete a Category entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm( $id ) {
        return $this->createFormBuilder()
                        ->setAction( $this->generateUrl( 'catalog_category_delete', array( 'id' => $id ) ) )
                        ->setMethod( 'DELETE' )
                        ->add( 'submit', 'submit', array( 'label' => 'Delete', ) )
                        ->getForm();
    }

}

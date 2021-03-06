<?php

namespace BooksBundle\Controller;

use BooksBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("user")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('BooksBundle:User')->findAll();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Lists all user entities.
     *
     * @Route("/reportUsers/PwzmEY3cn9FDV2wJwGeWSMRCzauHQg", name="user_report")
     * @Method("GET")
     */
    public function reportAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('BooksBundle:User')->findByRole("ROLE_USER");

        return $this->render('user/report.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Lists all user entities.
     *
     * @Route("/UsersMatcher", name="users_finder")
     * @Method("GET")
     */
    public function findAction()
    {
        $em = $this->getDoctrine()->getManager();
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        if(!$currentUser->hasTeam())
        {
            $this->addFlash(
                'notice',
                array(
                    'alert' => 'danger',// danger, warning, info, success
                    'title' => 'No pertenece a un equipo: ',
                    'message' => 'Debe crear o unirse a un equipo antes de buscar e invitar otros usuarios'
                )
            );
            
            return $this->redirectToRoute('team_new');
        }

        $users = $em->getRepository('BooksBundle:User')->wantedUsers($currentUser);

        $users_array = array();

        foreach ($users as $user) 
        {
            array_push($users_array, array($user,$user->getMatchScore($currentUser)));
        }

        usort($users_array, function ($a,$b){
            return $b[1]-$a[1];
        });

        return $this->render('user/finder.html.twig', array(
            'users_array' => $users_array,
        ));
    }

    /**
     * Creates a new user entity.
     *
     * @Route("/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('BooksBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $user->setRole('ROLE_USER');
            // Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }

        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('BooksBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        //no delete action
        return $this->redirectToRoute('home');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**                                                                                   
     * @Route("/chat", name="add_chat_ajax")
     */
    public function addChatAction(Request $request)    
    {
        if ($request->isXMLHttpRequest()) {         
            return new JsonResponse(array('data' => 'this is a json response'));
        }

        return new Response('This is not ajax!', 400);
    }
}

<?php
namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Formation;
use App\Entity\Image;

use App\Form\FormationType;
use App\Form\ParticipantType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Routing\Annotation\Route ;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class IndexController extends AbstractController
{

    #[Route('/home',name:'participant_list')]

  public function home()
  {

    $participants= $this->getDoctrine()->getRepository(Participant::class)->findAll();
    return  $this->render('participants/index.html.twig',['participants' => $participants]);  
  }



    /**
     * @Route("/participant/new", name="new_participant")
     * Method({"GET", "POST"})*/ 
    public function newParticipant(Request $request) {
      $participant = new Participant();
      $form = $this->createForm(ParticipantType::class,$participant);
        $form = $this->createFormBuilder($participant)
          ->add('nom', TextType::class,[
            'label' => 'Nom ' ])  
            ->add('email', TextType::class,[
              'label' => 'Email ' ])          
              ->add('telephone', IntegerType::class,[
                'label' => 'Telephone ' ])  
                ->add('image', EntityType::class, [
                  'class' => Image::class,
                  'choice_label' => 'url',
              ])


          ->add('formation',EntityType::class,['class' => Formation::class,
          'choice_label' => 'titre',
          'label' => 'Nom du formation '])
         
          ->getForm(); 
          $form->handleRequest($request);
          if($form->isSubmitted() && $form->isValid()) {
            $participant = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participant);
            $entityManager->flush();    
            return $this->redirectToRoute('participant_list');
          }
          return $this->render('participants/ajout.html.twig',['form' => $form->createView()]);
      }



      /**
     * @Route("/participant/{id}", name="participant_show")
     */
    public function show($id) {
      $participant = $this->getDoctrine()->getRepository(Participant::class)->find($id);

      return $this->render('participants/show.html.twig', array('participant' => $participant));
    }


  

    /**
     * @Route("/participant/edit/{id}", name="edit_participant")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
      $participant = new Participant();
      $participant = $this->getDoctrine()->getRepository(Participant::class)->find($id);
  
        $form = $this->createFormBuilder($participant)
        ->add('nom', TextType::class,[
          'label' => 'Nom ' ])  
          ->add('email', TextType::class,[
            'label' => 'Email ' ])          
            ->add('telephone', IntegerType::class,[
              'label' => 'Telephone ' ])  
              ->add('image', EntityType::class, [
                'class' => Image::class,
                'choice_label' => 'url',
            ])


        ->add('formation',EntityType::class,['class' => Formation::class,
        'choice_label' => 'titre',
        'label' => 'Nom du formation '])
        ->getForm();
  
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();
  
          return $this->redirectToRoute('participant_list');
        }
  
        return $this->render('participants/edit.html.twig', ['form' => $form->createView()]);
      }



   /**
     * @Route("/participant/delete/{id}",name="delete_participant")
     */
    public function delete(Request $request, $id): Response
    {
        $c = $this->getDoctrine()
            ->getRepository(Participant::class)
            ->find($id);
        if (!$c) {
            throw $this->createNotFoundException(
                'pas de participant avec id = '.$id
            );
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($c);

        $entityManager->flush();
        return $this->redirectToRoute('participant_list');
    }




    #[Route('/home1',name:'formation_list')]

    public function home1()
    {
  
      $formations= $this->getDoctrine()->getRepository(Formation::class)->findAll();
      return  $this->render('formations/index.html.twig',['formations' => $formations]);  
    }


     
    
    /**
     * @Route("/formation/new", name="new_formation")
     * Method({"GET", "POST"})
     */
    public function newFormation(Request $request) {
      $formation = new Formation();
    
      $form = $this->createForm(FormationType::class,$formation);

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {
        $formation = $form->getData();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($formation);
        $entityManager->flush();
        return $this->redirectToRoute('formation_list');
      }
      return $this->render('formations/new.html.twig',['form' => $form->createView()]);
  }


        /**
     * @Route("/formation/{id}", name="formation_show")
     */
    public function show2($id) {
      $formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);

      return $this->render('formations/show.html.twig', array('formation' => $formation));
    }



 /**
     * @Route("/formation/delete/{id}",name="delete_formation")
     */
    public function delete2(Request $request, $id): Response
    {
        $c = $this->getDoctrine()
            ->getRepository(Formation::class)
            ->find($id);
        if (!$c) {
            throw $this->createNotFoundException(
                'pas de formation  avec id = '.$id
            );
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($c);

        $entityManager->flush();
        return $this->redirectToRoute('formation_list');
    }

    #[Route('/arrire', name: 'arriere')]
    public function arriere()
    {
        return $this->render('page1/arriere.html.twig');
    }
}
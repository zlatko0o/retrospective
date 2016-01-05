<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Invitation;
use AppBundle\Entity\JobDone;
use AppBundle\Entity\Meeting;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MeetingsController extends Controller
{
	public function listAction( Request $request, $page )
	{
		$result = $this->getDoctrine()->getRepository( 'AppBundle:Meeting' )->getAll( $page );

		return $this->render( 'AppBundle:Meetings:list.html.twig', [ 'result' => $result ] );
	}

	public function createAction( Request $request )
	{

		$errors = [ ];

		if( strtolower( $request->getMethod() ) == "post" )
		{
			$name = $request->request->get( 'name', false );
			if( !$name )
				$errors[] = "Field name is required!";

			if( empty( $errors ) )
			{
				$meeting = new Meeting();
				$meeting->setDate( new \DateTime() );
				$meeting->setFinished( false );
				$meeting->setName( $name );
				$meeting->setAuthor( $this->getUser() );

				$em = $this->getDoctrine()->getManager();

				$em->persist( $meeting );
				$em->flush();

				return $this->redirect( $this->generateUrl( 'meeting', [ 'id' => $meeting->getId() ] ) );
			}
		}

		return $this->render( 'AppBundle:Meetings:create.html.twig', [ 'errors' => $errors ] );
	}

	public function meetingAction( Request $request, $id )
	{
		$em = $this->getDoctrine()->getManager();

		$meeting = $em->getRepository( 'AppBundle:Meeting' )->find( $id );

		if( !$meeting || $meeting->getAuthor() != $this->getUser() )
		{
			return $this->redirect( $this->generateUrl( 'index' ) );
		}

		return $this->render( 'AppBundle:Meetings:meeting.html.twig', [ 'meeting' => $meeting, 'jobs' => $this->getData( $meeting ) ] );
	}

	public function addJobAction( Request $request, $id, $type )
	{
		$em = $this->getDoctrine()->getManager();

		$meeting = $em->getRepository( 'AppBundle:Meeting' )->find( $id );
		if( !$meeting || $meeting->getFinished() )
			return new JsonResponse( [ 'meessage' => 'Invalid meeting' ] );

		$job = new JobDone();
		$job->setText( $request->request->get( 'text' ) );
		$job->setType( $type );
		$job->setMeeting( $meeting );

		$em->persist( $job );
		$em->flush();
		$em->clear();

		return new JsonResponse( [ 'data' => $this->getData( $meeting ) ] );
	}

	public function getJobsAction( Request $request, $id )
	{
		$em = $this->getDoctrine()->getManager();

		$meeting = $em->getRepository( 'AppBundle:Meeting' )->find( $id );
		if( !$meeting || $meeting->getFinished() )
			return new JsonResponse( [ 'meessage' => 'Invalid meeting' ] );

		return new JsonResponse( [ 'data' => $this->getData( $meeting ) ] );
	}

	public function getData( $meeting )
	{
		$em = $this->getDoctrine()->getManager();

		$data   = $em->getRepository( 'AppBundle:JobDone' )->findBy( [ 'meeting' => $meeting->getId() ] );
		$return = [ ];

		foreach( $data as $job )
		{
			$return[ $job->getType() ][] = $job->getText();
		}

		return $return;

	}

}

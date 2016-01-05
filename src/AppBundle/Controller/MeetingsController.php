<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Invitation;
use AppBundle\Entity\Meeting;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MeetingsController extends Controller
{
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

		return $this->render( 'AppBundle:Meetings:meeting.html.twig', [ 'meeting' => $meeting ] );
	}

}

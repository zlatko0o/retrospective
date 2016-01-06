<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Invitation;
use AppBundle\Entity\JobDone;
use AppBundle\Entity\Meeting;
use AppBundle\Entity\SafetyCheck;
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

		if( !$meeting )
		{
			return $this->redirect( $this->generateUrl( 'index' ) );
		}

		$notes = $this->get( 'note.service' )->getAllOrderedByHighestPriority( $this->getUser() );

		return $this->render( 'AppBundle:Meetings:meeting.html.twig', [
			'notes'   => $notes,
			'meeting' => $meeting,
			'data'    => $this->getData( $meeting ),
			'canVote' => $this->getUserVote( $meeting )
		] );
	}

	public function addJobAction( Request $request, $id, $type )
	{
		$em = $this->getDoctrine()->getManager();

		$meeting = $em->getRepository( 'AppBundle:Meeting' )->find( $id );
		if( !$meeting || $meeting->getFinished() )
			return new JsonResponse( [ 'meessage' => 'Invalid meeting' ] );

		$text = $request->request->get( 'text', false );

		if( $text )
		{
			$job = new JobDone();
			$job->setText( $text );
			$job->setType( $type );
			$job->setMeeting( $meeting );

			$em->persist( $job );
			$em->flush();
			$em->clear();
		}

		return new JsonResponse( [ 'data' => $this->getData( $meeting ) ] );
	}

	public function addActionAction( Request $request, $id, $type )
	{
		$em = $this->getDoctrine()->getManager();

		$meeting = $em->getRepository( 'AppBundle:Meeting' )->find( $id );
		if( !$meeting || $meeting->getFinished() )
			return new JsonResponse( [ 'meessage' => 'Invalid meeting' ] );

		$text = $request->request->get( 'text', false );

		if( $text )
		{
			$job = new JobDone();
			$job->setText( $text );
			$job->setType( $type );
			$job->setMeeting( $meeting );

			$em->persist( $job );
			$em->flush();
			$em->clear();
		}

		return new JsonResponse( [ 'data' => $this->getData( $meeting ) ] );
	}

	public function addVoteAction( Request $request, $id )
	{
		$em = $this->getDoctrine()->getManager();

		$meeting = $em->getRepository( 'AppBundle:Meeting' )->find( $id );
		if( !$meeting || $meeting->getFinished() )
			return new JsonResponse( [ 'meessage' => 'Invalid meeting' ] );

		if( $this->getUserVote( $meeting ) )
		{
			$sc = new SafetyCheck();
			$sc->setMeeting( $meeting );
			$sc->setUser( $this->getUser() );
			$sc->setLevel( $request->request->get( 'level' ) );

			$em->persist( $sc );
			$em->flush();
			$em->clear();
		}

		return new JsonResponse( [ 'data' => $this->getData( $meeting ) ] );
	}

	public function getDataAction( Request $request, $id )
	{
		$em = $this->getDoctrine()->getManager();

		$meeting = $em->getRepository( 'AppBundle:Meeting' )->find( $id );
		if( !$meeting || $meeting->getFinished() )
			return new JsonResponse( [ 'meessage' => 'Invalid meeting' ] );

		return new JsonResponse( [ 'data' => $this->getData( $meeting ) ] );
	}

	public function getData( Meeting $meeting )
	{
		$jobs   = $meeting->getJobDone();
		$return = [ ];

		foreach( $jobs as $job )
		{
			$return['jobs'][ $job->getType() ][] = $job->getText();
		}

		$alreadyVoted = $meeting->getSafetyChecks();

		$votes = [
			SafetyCheck::LEVEL_DANGEROUS   => 0,
			SafetyCheck::LEVEL_NEUTRAL     => 0,
			SafetyCheck::LEVEL_SAFE        => 0,
			SafetyCheck::LEVEL_SECURE      => 0,
			SafetyCheck::LEVEL_TREACHEROUS => 0,
		];

		foreach( $alreadyVoted as $sf )
		{
			$votes[ $sf->getLevel() ]++;
		}

		$return['votes'] = $votes;
		$return['actions'] = [];
		$actions = $meeting->getActions();

		foreach($actions as $action){
			$return['actions'][] = $action->getText();
		}

		return $return;
	}

	public function getUserVote( $meeting )
	{
		$em = $this->getDoctrine()->getManager();

		return !(bool)$em->getRepository( 'AppBundle:SafetyCheck' )
						 ->findOneBy( [
										  'meeting' => $meeting->getId(),
										  'user'    => $this->getUser()->getId()
									  ] );
	}

}

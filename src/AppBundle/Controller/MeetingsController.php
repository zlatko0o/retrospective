<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Invitation;
use AppBundle\Entity\Meeting;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MeetingsController extends Controller
{
	public function createAction()
	{

		$em = $this->getDoctrine()->getManager();

		$teamMates = $this->getDoctrine()->getRepository( 'AppBundle:Meeting' )->getTeamMates( $this->getUser() );
		$meeting   = new Meeting();
		$meeting->setDate( new \DateTime() );
		$meeting->setFinished( false );

		$em->persist( $meeting );
		$em->flush();

		return $this->render( 'AppBundle:Meetings:create.html.twig', [
			'teammates' => $teamMates,
			'meeting'   => $meeting->getId()
		] );
	}

	public function inviteAction( Request $request )
	{
		$doctrine = $this->getDoctrine();
		$members  = $this->getUser()->getTeam()->getUsers()->toArray();

		$meetingId = $request->request->get( 'meeting_id' );

		$meeting = $doctrine->getRepository( 'AppBundle:Meeting' )->find( $meetingId );

		if( !$meeting || $meeting->getFinished() )
			return new JsonResponse( [ 'message' => 'Meeting is finished' ] );

		$user = $doctrine->getRepository( 'AppBundle:User' )
						 ->findOneBy( [
										  'id' => $request->request->get( 'id' )
									  ] );
		if( !$user || !in_array( $user, $members ) )
			return new JsonResponse( [ 'message' => 'Invalid User' ] );

		$invitation = new Invitation();
		$invitation->setDate( new \DateTime() );
		$invitation->setMeeting( $meeting );

		$em = $doctrine->getManager();
		$em->persist( $invitation );
		$em->flush();

		return new JsonResponse( [ 'message' => 'Success' ] );
	}

}

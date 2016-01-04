<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MeetingsController extends Controller
{
	public function createAction()
	{

		$teamMates = $this->getDoctrine()->getRepository( 'AppBundle:Meeting' )->getTeamMates( $this->getUser() );

		return $this->render( 'AppBundle:Meetings:create.html.twig', [
			'teammates' => $teamMates
		] );
	}

	public function inviteAction( Request $request )
	{
		/**
		 * @var \AppBundle\Entity\Team
		 */
		$team = $this->getUser()->getTeam()->getUsers();

		$user = $this->getDoctrine()->getRepository( 'AppBundle:User' )
					 ->findOneBy( [
									  'id' => $request->request->get( 'id' )
								  ] );

		if( !$user || !in_array( $user, $team ) )
			return new JsonResponse( [ 'message' => 'Invalid User' ] );

		//TODO send invites
	}

}

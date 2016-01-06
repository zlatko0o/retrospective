<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class IndexController extends Controller
{
	const LAST_MEETINGS_NUM = 10;
	const LAST_NOTIFICATIONS_NUM = 10;

	public function indexAction()
	{
		if( !$this->getUser() )
			return $this->redirect( $this->generateUrl( 'fos_user_security_login' ) );

		return $this->render( 'AppBundle:IndexController:index.html.twig', [
			// ...
		] );
	}

	public function getTeammatesAction()
	{
		$team       = $this->getUser()->getTeam();
		$returnData = [];
		if( !$team )
			return new JsonResponse( ['status' => 'success', 'data' => $returnData] );

		$data = $team->getUsers();

		if( $data )
		{
			$returnData['team']['id']   = $team->getId();
			$returnData['team']['name'] = $team->getName();
			$returnData['users'] = [];
			$users = &$returnData['users'];
			$cnt = 0;
			foreach( $data as $key => $user )
			{
				if( $user->getId() == $this->getUser()->getId() )
					continue;

				$users[$cnt]['id']       = $user->getId();
				$users[$cnt]['username'] = $user->getUsername();
				$users[$cnt]['email']    = $user->getEmail();
				$cnt++;
			}
		}

		return new JsonResponse( [
			'status' => 'success',
			'data'   => $returnData
		] );
	}

	public function getLastRetrospectivesAction()
	{
		$em         = $this->getDoctrine()->getManager();
		$repo       = $em->getRepository('AppBundle:Meeting');
		$returnData = [];
		$team       = $this->getUser()->getTeam();

		if( !$team )
			return new JsonResponse( ['status' => 'success', 'data' => $returnData] );

		$data = $repo->getLastMeetings( $team, self::LAST_MEETINGS_NUM );

		if( $data )
		{
			foreach( $data as $key => $meeting )
			{
				$returnData[$key]['id']              = $meeting->getId();
				$returnData[$key]['name']            = strip_tags( $meeting->getName() );
				$returnData[$key]['date']            = $meeting->getDate();
				$returnData[$key]['finished']        = $meeting->getFinished();
				$returnData[$key]['author_username'] = strip_tags( $meeting->getAuthor()->getUsername() );
			}
		}

		return new JsonResponse( [
			'status' => 'success',
			'data'   => $returnData
		] );
	}

	public function getLastNotificationsAction()
	{
		$em         = $this->getDoctrine()->getManager();
		$repo       = $em->getRepository( 'AppBundle:Notification' );
		$returnData = [];

		$data = $repo->getLastNotifications( $this->getUser(), self::LAST_NOTIFICATIONS_NUM );

		if( $data )
		{
			foreach( $data as $key => $notification )
			{
				//TODO: implement this
			}
		}

		return new JsonResponse( [
			'status' => 'success',
			'data'   => $returnData
		] );
	}

	public function getActionsAction()
	{
		$em         = $this->getDoctrine()->getManager();
		$repo       = $em->getRepository( 'AppBundle:Action' );
		$returnData = [];
		$team       = $this->getUser()->getTeam();

		if( !$team )
			return new JsonResponse( ['status' => 'success', 'data' => $returnData] );

		$data = $repo->getAllActionsByTeam( $team );

		if( $data )
		{
			foreach( $data as $key => $action )
			{
				$returnData[$key]['id']               = $action->getId();
				$returnData[$key]['checked']          = $action->getChecked();
				$meeting                              = $action->getMeeting();
				$returnData[$key]['meeting_id']       = $meeting->getId();
				$returnData[$key]['meeting_name']     = strip_tags( $meeting->getName() );
				$returnData[$key]['text']             = strip_tags( $action->getText() );
			}
		}

		return new JsonResponse( [
			'status' => 'success',
			'data'   => $returnData
		] );
	}

}

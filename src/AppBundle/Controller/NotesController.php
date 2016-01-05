<?php

namespace AppBundle\Controller;

use AppBundle\Service\NoteService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class NotesController extends Controller
{
	public function indexAction()
	{
		$noteService = $this->get( 'note.service' );
		$currentUser = $this->getUser();

		$notes = $noteService->getAllOrderedByHighestPriority( $currentUser );

		return $this->render( 'AppBundle:Notes:index.html.twig', [
			'notes' => $notes
		] );
	}

	public function saveAction( Request $request )
	{
		$text = trim( strip_tags( $request->request->get( 'noteText' ) ) );

		if( !is_string( $text ) || empty( $text ) )
			return new JsonResponse( [
				 'status' => 'error',
				 'msg'    => 'Invalid text'
			 ] );

		$noteService = $this->get( 'note.service' );
		$currentUser = $this->getUser();

		$note = $noteService->addNote( $currentUser, $text );

		if( $note === false )
			return new JsonResponse( [
				 'status' => 'error',
				 'msg'    => 'You have exceeded the note limit (' . NoteService::MAX_ALLOWED_NOTES . ')'
			 ] );

		return new JsonResponse( [
			 'status' => 'success',
			 'note'   => $note
		 ] );
	}

	public function reorderAction( Request $request )
	{
		$reorderId = $request->request->get( 'dragId' );
		$nextId    = $request->request->get( 'nextId' );

		if( !is_numeric( $reorderId ) || $reorderId < 1 )
			return new JsonResponse( [
				 'status' => 'error',
				 'msg'    => 'Invalid note for reorder'
			 ] );

		if( !is_numeric( $nextId ) )
			return new JsonResponse( [
				 'status' => 'error',
				 'msg'    => 'Invalid note'
			 ] );

		if( $nextId > 0 )
		{
			$noteService = $this->get( 'note.service' );
			$currentUser = $this->getUser();
			$notes       = $noteService->changePriority( $currentUser, $reorderId, $nextId );

			return new JsonResponse( [
				 'status' => 'success',
				 'notes'  => $notes
			 ] );
		}

		return new JsonResponse( [
			 'status' => 'success',
			 'notes'  => []
		 ] );

	}
}
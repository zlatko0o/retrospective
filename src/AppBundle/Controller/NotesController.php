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
		$reorderId = $request->request->get( 'reorderId' );
		$reorderId = $request->request->get( 'reorderId' );
	}
}
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
		$currentUser = $this->getUser();
		$noteService = $this->get( 'note.service' );

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

		$currentUser = $this->getUser();
		$noteService = $this->get( 'note.service' );

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

	public function deleteAction( Request $request )
	{
		$noteId = $request->request->get( 'noteId' );
		if( !is_numeric( $noteId ) || $noteId < 1 )
			return new JsonResponse( [
				'status' => 'error',
				'msg'    => 'Invalid note'
			] );

		$currentUser = $this->getUser();
		$noteService = $this->get( 'note.service' );
		$noteService->removeNoteById( $currentUser, $noteId );

		return new JsonResponse( [ 'status' => 'success' ] );
	}

	public function reorderAction( Request $request )
	{
		$notes  = $request->request->get( 'notes' );

		if( !is_array( $notes ) )
			return new JsonResponse( [
				 'status' => 'error',
				 'msg'    => 'Invalid notes'
			 ] );

		$currentUser = $this->getUser();
		$noteService = $this->get( 'note.service' );
		$noteService->changePriority( $currentUser, $notes );

		return new JsonResponse( [ 'status' => 'success' ] );

	}
}
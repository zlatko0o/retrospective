<?php

namespace AppBundle\Service;

use AppBundle\Entity\Note;
use AppBundle\Entity\User;
use AppBundle\Repository\NoteRepository;
use Doctrine\ORM\EntityManager;

class NoteService
{
	/**
	 * @var NoteRepository
	 */
	private $repo;

	/**
	 * @var EntityManager
	 */
	private $em;

	const MAX_ALLOWED_NOTES = 100;

	/**
	 * @param NoteRepository $repo
	 * @param EntityManager  $em
	 */
	public function __construct( NoteRepository $repo, EntityManager $em )
	{
		$this->repo = $repo;
		$this->em   = $em;
	}

	public function changePriority( User $user, $notes )
	{
		$notesCount = count( $notes );
		foreach( $notes as $key => $n )
		{
			if(isset($n['noteId']) && isset($n['priority'])
				&& is_numeric($n['noteId']) && is_numeric($n['priority'])
				&& $n['noteId'] > 0 && $n['priority'] > 0)
			{
				$flush = $notesCount == $key + 1;
				$this->repo->updatePriority( $user, $n['noteId'], $n['priority'], $flush );
			}
		}

		return true;
	}

	public function removeNoteById( User $user, $noteId )
	{
		$notes = $this->repo->findBy( [
			'user' => $user,
			'id'   => $noteId
		] );

		if( isset($notes[0]) )
		{
			$this->em->remove( $notes[0] );
			$this->em->flush();

			$this->repo->refreshPriority( $user );
		}

	}

	public function addNote( User $user, $text )
	{
		$count = $this->repo->countAll( $user );
		if( $count > self::MAX_ALLOWED_NOTES )
			return false;

		$note = new Note();
		$note->setText( $text );
		$note->setUser( $user );
		$note->setPriority( $count + 1 );

		$this->em->persist( $note );
		$this->em->flush();

		return $note;
	}

	public function getAllOrderedByHighestPriority( User $user )
	{
		return $this->repo->findByUserOrderedByPriority( $user );
	}

	public function getNotePriority( User $user, $noteId )
	{
		$notes = $this->repo->findBy( [
			'user' => $user,
			'id'   => $noteId
		 ] );

		if( !isset( $notes[0] ) )
			return false;

		return $notes[0]->getPriority();
	}
}
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

	public function changePriority( $noteId, $newPriority )
	{
		$note = $this->repo->find( $noteId );

		if( $note )
		{
			$this->repo->increasePriorityOfHigherThan( $newPriority, 1 );

			$note->setPriority( $newPriority );
			$this->em->persist( $note );
			$this->em->flush();
		}

		return true;
	}

	public function removeNoteById( $noteId )
	{
		$note = $this->repo->find( $noteId );

		if( $note )
		{
			$this->em->remove( $noteId );
			$this->em->flush();

			$this->repo->decreasePriorityOfHigherThan( $note->getPriority(), 1 );
		}

		return true;
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
}
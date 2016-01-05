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

	public function changePriority( User $user, $noteId, $nextId )
	{
		//TODO: finish at home
		/*$newPriority = $this->getNotePriority( $user, $nextId );

		$notes = $this->repo->findBy( [
			'user' => $user,
			'id'   => $noteId
		 ] );

		if( isset($notes[0]) )
		{
			$oldPriority = $notes[0]->getPriority();

			if( $oldPriority > $newPriority ) // drag down
			{
				$this->repo->increasePriorityBetween( $newPriority, 1 );
			}
			else if( $oldPriority < $newPriority ) // drag up
			{

			}

			$notes[0]->setPriority( $newPriority );
			$this->em->persist( $notes[0] );
			$this->em->flush();
		}*/

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
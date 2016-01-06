<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

class NoteRepository extends EntityRepository
{
	public function updatePriority( User $user, $noteId, $priority, $flush = false )
	{
		$notes = $this->findBy( [
			'id'   => $noteId,
			'user' => $user
		] );

		if( isset($notes[0]) )
		{
			$notes[0]->setPriority( $priority );
			$this->_em->persist( $notes[0] );
			if( $flush )
				$this->_em->flush();
		}
	}

	public function refreshPriority( User $user )
	{
		$notes = $this->findByUserOrderedByPriority( $user, 'ASC' );
		$notesCount = count( $notes );

		foreach( $notes as $key => $n )
		{
			$flush = $notesCount == $key + 1;
			$this->updatePriority($user, $n->getId(), $key + 1, $flush);
		}
	}

	public function countAll( User $user )
	{
		return $this->getEntityManager()
					->createQueryBuilder()
					->select( 'count(n.id)' )
					->from( 'AppBundle:Note', 'n' )
					->where( 'n.user = :user' )
					->setParameter( 'user', $user )
					->getQuery()
					->getSingleScalarResult();
	}

	public function findByUserOrderedByPriority( User $user, $orderType = 'DESC' )
	{
		$orderType = strtoupper( $orderType );
		if( in_array( $orderType, [ 'DESC', 'DESC' ] ) )
			$orderType = 'DESC';

		return $this->getEntityManager()
					->createQueryBuilder()
					->select( 'n' )
					->from( 'AppBundle:Note', 'n' )
					->orderBy( 'n.priority', $orderType )
					->getQuery()
					->getResult();
	}
}
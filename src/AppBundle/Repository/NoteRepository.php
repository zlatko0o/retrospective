<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

class NoteRepository extends EntityRepository
{
	public function decreasePriorityOfHigherThan( $priority, $offset )
	{
		return $this->changePriority( $priority, $offset, '-' );
	}

	public function increasePriorityOfHigherThan( $priority, $offset )
	{
		return $this->changePriority( $priority, $offset, '+' );
	}

	private function changePriority( $priority, $offset, $sign )
	{
		if( !in_array( $sign, [ '+', '-' ] ) )
			return false;

		return $this->getEntityManager()
					->createQueryBuilder()
					->update( 'AppBundle:Note', 'n' )
					->set( 'n.priority', 'n.priority ' . $sign . ' ' . (int)$offset )
					->where( 'n.priority > :priority' )
					->setParameter( 'priority', (int)$priority )
					->getQuery()
					->execute();
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
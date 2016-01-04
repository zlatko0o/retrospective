<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * MeetingRepository
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MeetingRepository extends EntityRepository
{
	public function getTeamMates( User $user )
	{
		return $user->getTeam()->getUsers();
	}
}

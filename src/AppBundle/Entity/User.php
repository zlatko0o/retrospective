<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

	/**
	 * @var Team
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Team", inversedBy="id")
	 */
	protected $team;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

}
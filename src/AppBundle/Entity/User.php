<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

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
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Team", inversedBy="users")
	 * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
	 */
	protected $team;

	/**
	 * @var array
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Meeting", mappedBy="author")
	 */
	protected $meetings;

	/**
	 * @var array
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notification", mappedBy="user")
	 */
	protected $notifications;

	public function __construct()
	{
		parent::__construct();
		// your own logic
	}

	/**
	 * @return \AppBundle\Entity\Team
	 */
	public function getTeam()
	{
		return $this->team;
	}

	/**
	 * @param mixed $team
	 */
	public function setTeam( $team )
	{
		$this->team = $team;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId( $id )
	{
		$this->id = $id;
	}

	/**
	 * @return array
	 */
	public function getMeetings()
	{
		return $this->meetings;
	}

	/**
	 * @param array $meetings
	 */
	public function setMeetings( $meetings )
	{
		$this->meetings = $meetings;
	}

	/**
	 * @return array
	 */
	public function getNotifications()
	{
		return $this->notifications;
	}

	/**
	 * @param array $notifications
	 */
	public function setNotifications( $notifications )
	{
		$this->notifications = $notifications;
	}

}
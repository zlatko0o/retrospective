<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 * @ORM\Table(name="notifications")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NotificationRepository")
 */
class Notification
{
	/**
	 * @var int
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var \DateTime
	 * @ORM\Column(name="dateCreated", type="datetime")
	 */
	private $dateCreated;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="notifications")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 */
	protected $user;

	/**
	 * @var Meeting
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Meeting" )
	 * @ORM\JoinColumn(name="meeting_id", referencedColumnName="id")
	 */
	protected $meeting;

	/**
	 * Get id
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set dateCreated
	 *
	 * @param \DateTime $dateCreated
	 * @return Notification
	 */
	public function setDateCreated( $dateCreated )
	{
		$this->dateCreated = $dateCreated;

		return $this;
	}

	/**
	 * Get dateCreated
	 *
	 * @return \DateTime
	 */
	public function getDateCreated()
	{
		return $this->dateCreated;
	}

	/**
	 * @return mixed
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * @param mixed $user
	 */
	public function setUser( $user )
	{
		$this->user = $user;
	}

	/**
	 * @return Meeting
	 */
	public function getMeeting()
	{
		return $this->meeting;
	}

	/**
	 * @param Meeting $meeting
	 */
	public function setMeeting( $meeting )
	{
		$this->meeting = $meeting;
	}

}


<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Meeting
 * @ORM\Table(name="meeting")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MeetingRepository")
 */
class Meeting
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
	 * @ORM\Column(name="date", type="datetime")
	 */
	private $date;

	/**
	 * @var bool
	 * @ORM\Column(name="finished", type="boolean")
	 */
	private $finished;

	/**
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Invitation", mappedBy="meeting")
	 */
	protected $invitations;

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
	 * Set date
	 *
	 * @param \DateTime $date
	 * @return Meeting
	 */
	public function setDate( $date )
	{
		$this->date = $date;

		return $this;
	}

	/**
	 * Get date
	 *
	 * @return \DateTime
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * Set finished
	 *
	 * @param boolean $finished
	 * @return Meeting
	 */
	public function setFinished( $finished )
	{
		$this->finished = $finished;

		return $this;
	}

	/**
	 * Get finished
	 *
	 * @return bool
	 */
	public function getFinished()
	{
		return $this->finished;
	}

	/**
	 * @return mixed
	 */
	public function getInvitations()
	{
		return $this->invitations;
	}

	/**
	 * @param mixed $invitations
	 */
	public function setInvitations( $invitations )
	{
		$this->invitations = $invitations;
	}

}


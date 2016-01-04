<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invitation
 * @ORM\Table(name="invitation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InvitationRepository")
 */
class Invitation
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
	 * @var Meeting
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Meeting", inversedBy="invitations")
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
	 * Set date
	 *
	 * @param \DateTime $date
	 * @return Invitation
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


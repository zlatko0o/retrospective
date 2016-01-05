<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
	 * @ORM\Id
	 * @ORM\Column(name="id", type="integer")
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
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="meetings")
	 * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
	 */
	protected $author;

	/**
	 * @var array
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\SafetyCheck", mappedBy="id")
	 */
	protected $safetyChecks = null;

	/**
	 * @var array
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\JobDone", mappedBy="id")
	 */
	protected $jobDone = null;

	/**
	 * @var array
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Action", mappedBy="id")
	 */
	protected $actions = null;

	/**
	 * @var string
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	protected $name;

	public function __construct()
	{
		$this->safetyChecks = new ArrayCollection();
		$this->jobDone      = new ArrayCollection();
		$this->actions      = new ArrayCollection();
	}

	/**
	 * Add safety checks
	 *
	 * @param SafetyCheck $safetyCheck
	 * @return Meeting
	 */
	public function addSafetyCheck( SafetyCheck $safetyCheck )
	{
		$this->safetyChecks[] = $safetyCheck;

		return $this;
	}

	/**
	 * Remove safety check
	 *
	 * @param SafetyCheck $safetyCheck
	 */
	public function removeSafetyCheck( SafetyCheck $safetyCheck )
	{
		$this->safetyChecks->removeElement( $safetyCheck );
	}

	/**
	 * Get safety checks
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getSafetyChecks()
	{
		return $this->safetyChecks;
	}

	/**
	 * Add job done
	 *
	 * @param JobDone $jobDone
	 * @return Meeting
	 */
	public function addJobDone( JobDone $jobDone )
	{
		$this->jobDone[] = $jobDone;

		return $this;
	}

	/**
	 * Remove job done
	 *
	 * @param JobDone $jobDone
	 */
	public function removeJobDone( JobDone $jobDone )
	{
		$this->jobDone->removeElement( $jobDone );
	}

	/**
	 * Get job done
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getJobDone()
	{
		return $this->jobDone;
	}

	/**
	 * Add action
	 *
	 * @param Action $action
	 * @return Meeting
	 */
	public function addAction( Action $action )
	{
		$this->actions[] = $action;

		return $this;
	}

	/**
	 * Remove job done
	 *
	 * @param Action $action
	 */
	public function removeAction( Action $action )
	{
		$this->actions->removeElement( $action );
	}

	/**
	 * Get job done
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getActions()
	{
		return $this->actions;
	}

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

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName( $name )
	{
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * @param mixed $author
	 */
	public function setAuthor( $author )
	{
		$this->author = $author;
	}

}


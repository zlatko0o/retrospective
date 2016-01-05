<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Team", inversedBy="users")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     */
	protected $team;

	/**
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Note", mappedBy="user")
	 */
	protected $notes;

	/**
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\SafetyCheck", mappedBy="user")
	 */
	protected $safetyChecks;

	/**
	 * Constructor
	 */
    public function __construct()
    {
        parent::__construct();

		$this->notes        = new ArrayCollection();
		$this->safetyChecks = new ArrayCollection();
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
	 * Add notes
	 *
	 * @param Note $note
	 * @return User
	 */
	public function addNote( Note $note )
	{
		$this->notes[] = $note;

		return $this;
	}

	/**
	 * Remove notes
	 *
	 * @param Note $note
	 */
	public function removeNote( Note $note )
	{
		$this->notes->removeElement( $note );
	}

	/**
	 * Get notes
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getNotes()
	{
		return $this->notes;
	}

	/**
	 * Add files
	 *
	 * @param SafetyCheck $safetyCheck
	 * @return User
	 */
	public function addSafetyCheck( SafetyCheck $safetyCheck )
	{
		$this->safetyChecks[] = $safetyCheck;

		return $this;
	}

	/**
	 * Remove Safety check
	 *
	 * @param SafetyCheck $safetyCheck
	 */
	public function removeSafetyCheck( SafetyCheck $safetyCheck )
	{
		$this->notes->removeElement( $safetyCheck );
	}

	/**
	 * Get Safety checks
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getSafetyChecks()
	{
		return $this->safetyChecks;
	}



}
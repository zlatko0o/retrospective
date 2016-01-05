<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SafetyCheck
 *
 * @ORM\Entity
 * @ORM\Table(name="safety_check")
 */
class SafetyCheck
{
	/**
	 * @var int
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var User
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="safetyChecks")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 */
	protected $user;

	/**
	 * @var int
	 * @ORM\Column(name="level", type="integer", length=1)
	 */
	protected $level;

	/**
	 * @var Meeting
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Meeting", inversedBy="safetyChecks")
	 * @ORM\JoinColumn(name="meeting_id", referencedColumnName="id")
	 */
	protected $meeting;

	const LEVEL_TREACHEROUS = 0;
	const LEVEL_DANGEROUS = 1;
	const LEVEL_NEUTRAL = 2;
	const LEVEL_SAFE = 3;
	const LEVEL_SECURE = 4;

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
	 * Set user
	 *
	 * @param User $user
	 * @return Notes
	 */
	public function setUser( User $user )
	{
		$this->user = $user;

		return $this;
	}

	/**
	 * Get user
	 *
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * Set level
	 *
	 * @param int $level
	 * @return $this
	 */
	public function setLevel( $level )
	{
		$levels = [
			self::LEVEL_TREACHEROUS,
			self::LEVEL_DANGEROUS,
			self::LEVEL_NEUTRAL,
			self::LEVEL_SAFE,
			self::LEVEL_SECURE
		];

		if( !in_array( $level, $levels ) )
			$level = self::LEVEL_NEUTRAL;

		$this->level = $level;

		return $this;
	}

	/**
	 * Get level
	 *
	 * @return int
	 */
	public function getLevel()
	{
		return $this->level;
	}

	/**
	 * Set Meeting
	 *
	 * @param Meeting $meeting
	 * @return Action
	 */
	public function setMeeting( $meeting )
	{
		$this->meeting = $meeting;

		return $this;
	}

	/**
	 * Get Meeting
	 *
	 * @return Meeting
	 */
	public function getMeeting()
	{
		return $this->meeting;
	}
}
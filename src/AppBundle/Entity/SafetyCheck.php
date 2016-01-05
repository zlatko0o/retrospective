<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actions
 * @ORM\Table(name="actions")
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
		if( $level != self::LEVEL_TREACHEROUS
			&& $level != self::LEVEL_DANGEROUS
			&& $level != self::LEVEL_NEUTRAL
			&& $level != self::LEVEL_SAFE
			&& $level != self::LEVEL_SECURE )
		{
			$level = self::LEVEL_NEUTRAL;
		}

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
}
<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actions
 * @ORM\Entity
 * @ORM\Table(name="job_done")
 */
class JobDone
{
	/**
	 * @var int
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var int
	 * @ORM\Column(name="type", type="integer", length=1)
	 */
	protected $type;

	/**
	 * @var string
	 * @ORM\Column(name="text", type="string", length=100)
	 */
	protected $text;

	const TYPE_NEUTRAL = 0;
	const TYPE_WELL = 1;
	const TYPE_NOTWELL = 2;

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
	 * Set type
	 *
	 * @param int $type
	 * @return $this
	 */
	public function setType( $type )
	{
		$types = [
			self::TYPE_NEUTRAL,
			self::TYPE_WELL,
			self::TYPE_NOTWELL
		];

		if( !in_array($type , $types) )
			$type = self::TYPE_NEUTRAL;

		$this->type = $type;

		return $this;
	}

	/**
	 * Get type
	 *
	 * @return int
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Get text
	 *
	 * @return string
	 */
	public function getText()
	{
		return $this->text;
	}

	/**
	 * Set text
	 *
	 * @param string $text
	 * @return Actions
	 */
	public function setText( $text )
	{
		$this->text = $text;

		return $this;
	}
}
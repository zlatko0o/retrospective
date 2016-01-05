<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Action
 * @ORM\Entity
 * @ORM\Table(name="actions")
 */
class Action
{
	/**
	 * @var int
	 * @ORM\Id
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var boolean
	 * @ORM\Column(name="is_deleted", type="boolean")
	 */
	protected $checked;

	/**
	 * @var string
	 * @ORM\Column(name="text", type="string", length=150)
	 */
	protected $text;

	/**
	 * @var Meeting
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Meeting", inversedBy="actions")
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
	 * @return Action
	 */
	public function setText( $text )
	{
		$this->text = $text;

		return $this;
	}

	/**
	 * Set checked
	 *
	 * @param boolean $checked
	 * @return Action
	 */
	public function setChecked( $checked )
	{
		$this->checked = (bool)$checked;

		return $this;
	}

	/**
	 * Get checked
	 *
	 * @return boolean
	 */
	public function getChecked()
	{
		return $this->checked;
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
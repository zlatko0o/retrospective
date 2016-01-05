<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actions
 * @ORM\Table(name="actions")
 */
class Actions
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
	 * @return Actions
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
	 * @return Actions
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
}
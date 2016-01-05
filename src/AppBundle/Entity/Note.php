<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notes
 * @ORM\Entity
 * @ORM\Table(name="notes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NoteRepository")
 */
class Note implements \JsonSerializable
{
	/**
	 * @var int
	 * @ORM\Id
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var User
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="notes")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 */
	protected $user;

	/**
	 * @var string|null
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    protected $text;

	/**
	 * @var int
     * @ORM\Column(name="priority", type="integer")
     */
    protected $priority;

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
	 * @return Note
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
     * Set text
     *
     * @param string $text
     * @return Note
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
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
     * Set priority
     *
     * @param string $priority
     * @return Note
     */
    public function setPriority($priority)
    {
        $this->priority = (int)$priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

	/**
	 * (PHP 5 &gt;= 5.4.0)<br/>
	 * Specify data which should be serialized to JSON
	 *
	 * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 *       which is a value of any type other than a resource.
	 */
	function jsonSerialize()
	{
		return [
			'id' => $this->id,
			'text' => nl2br( $this->text ),
			'user' => [
				'id' => $this->user->getId(),
				'username' => $this->user->getUsername()
			],
			'priority' => $this->priority
		];
}}
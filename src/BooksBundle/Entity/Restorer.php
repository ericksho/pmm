<?php

namespace BooksBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Restorer
 *
 * @ORM\Table(name="restorer")
 * @ORM\Entity(repositoryClass="BooksBundle\Repository\RestorerRepository")
 */
class Restorer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime")
     */
    private $time;

    /**
     * @var string
     *
     * @ORM\Column(name="auth", type="string", length=60)
     */
    private $auth;

    /**
    * @ORM\OneToOne(targetEntity="User", inversedBy="restorer", cascade={"persist"})
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;

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
     * Set time
     *
     * @param \DateTime $time
     *
     * @return Restorer
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set auth
     *
     * @param string $auth
     *
     * @return Restorer
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;

        return $this;
    }

    /**
     * Get auth
     *
     * @return string
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * Set user
     *
     * @param \BooksBundle\Entity\User $user
     *
     * @return Restorer
     */
    public function setUser(\BooksBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \BooksBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}

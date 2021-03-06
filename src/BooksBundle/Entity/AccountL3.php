<?php

namespace BooksBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AccountL3
 *
 * @ORM\Table(name="account_l3")
 * @ORM\Entity(repositoryClass="BooksBundle\Repository\AccountL3Repository")
 */
class AccountL3
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="code", type="integer")
     */
    private $code;

    /**
     * Many AccountsL3 have One AccountL2.
     * @ORM\ManyToOne(targetEntity="AccountL2", inversedBy="accountsL3")
     * @ORM\JoinColumn(name="accountL2_id", referencedColumnName="id")
     */
    private $accountL2;

    /**
     * One AccountL3 has Many Items
     * @ORM\OneToMany(targetEntity="Item", mappedBy="accountL3")
     */
    private $items;

    public function __construct() {
        $this->items = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return AccountL3
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set code
     *
     * @param integer $code
     * @return AccountL3
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return integer 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get code string
     *
     * @return integer 
     */
    public function getCodeString()
    {
        return str_pad($this->code, 2, "0", STR_PAD_LEFT);;
    }

    /**
     * Get code string
     *
     * @return integer 
     */
    public function getFullCode()
    {
        return $this->accountL2->getAccountL1()->getCodeString().'-'.$this->accountL2->getCodeString().'-'.$this->getCodeString();
    }

    /**
     * Set accountL2
     *
     * @param \BooksBundle\Entity\AccountL2 $accountL2
     * @return AccountL3
     */
    public function setAccountL2(\BooksBundle\Entity\AccountL2 $accountL2 = null)
    {
        $this->accountL2 = $accountL2;

        return $this;
    }

    /**
     * Get accountL2
     *
     * @return \BooksBundle\Entity\AccountL2 
     */
    public function getAccountL2()
    {
        return $this->accountL2;
    }

    /**
     * Get vouchers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVouchers()
    {
        return $this->vouchers;
    }

    public function fitMinorFilter($state, $date1, $date2)
    {
        foreach ($this->vouchers as $voucher)
        {
            if($voucher->fitMinorFilter($state, $date1, $date2))
                return true;
        }
        return false;
    }

    public function getRowspan()
    {
        $rowspan = 1;

        foreach ($this->vouchers as $voucher) 
        {
            $rowspan += $voucher->getRowspan();
        }

        return $rowspan;
    }

    /**
     * Add items
     *
     * @param \BooksBundle\Entity\Item $items
     * @return AccountL3
     */
    public function addItem(\BooksBundle\Entity\Item $items)
    {
        $this->items[] = $items;

        return $this;
    }

    /**
     * Remove items
     *
     * @param \BooksBundle\Entity\Item $items
     */
    public function removeItem(\BooksBundle\Entity\Item $items)
    {
        $this->items->removeElement($items);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->items;
    }
}

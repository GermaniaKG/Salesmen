<?php
namespace Germania\Salesmen;

use Germania\Retailers\RetailerNumberAwareTrait;

class SalesmanAbstract implements SalesmanInterface
{
    use RetailerNumberAwareTrait,
        SalesmanIdAwareTrait;

    /**
     * @var string
     */
    public $first_name;

    /**
     * @var string
     */
    public $last_name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var int
     */
    public $user_id;

    /**
     * @var int
     */
    public $is_active;



    /**
     * @return array
     */
    public function __debugInfo() {
        return [
            'SalesmanID' => $this->getSalesmanId(),
            'FullName'   => $this->getFullName(),
            'Email'      => $this->getEmail(),
            'isActive'   => $this->isActive(),
            'UserID'     => $this->getUserId()
        ];
    }


    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }


    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }


    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * @return string
     */
    public function getUserId() {
        return $this->user_id;
    }


    /**
     * @return bool
     */
    public function isActive() {
        return (bool) ((int) $this->is_active > 0);
    }


    /**
     * @return string
     */
    public function getFullName()
    {
        return trim( join(" ", array_filter([
            $this->getFirstName(),
            $this->getLastName()
        ])));
    }


    /**
     * @return string
     */
    public function getDisplayName()
    {
        return trim( join(" ∙ ", array_filter([
            $this->getFullName(),
            $this->getSalesmanId()
        ])));
    }




}

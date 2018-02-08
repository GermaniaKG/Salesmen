<?php
namespace Germania\Salesmen;

use Germania\Retailers\RetailerNumberProviderInterface;

interface SalesmanInterface extends RetailerNumberProviderInterface, SalesmanIdProviderInterface
{

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @return string
     */
    public function getLastName();


    /**
     * @return string
     */
    public function getFullName();


    /**
     * @return string
     */
    public function getDisplayName();


    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return boolean
     */
    public function isActive();

    /**
     * @return int
     */
    public function getUserId();
}

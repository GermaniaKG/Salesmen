<?php
namespace Germania\Salesmen;

interface SalesmanInterceptorsInterface extends SalesmanProviderInterface
{

    /**
     * Sets the Salesman ID.
     *
     * @var     int|string $salesman_id
     * @return  self
     */
    public function setSalesmanId( $id );
}

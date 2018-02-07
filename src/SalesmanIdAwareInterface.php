<?php
namespace Germania\Salesmen;

interface SalesmanIdAwareInterface extends SalesmanIdProviderInterface
{

    /**
     * Sets the Salesman ID.
     *
     * @var     int|string $salesman_id
     * @return  self
     */
    public function setSalesmanId( $id );
}

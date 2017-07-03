<?php
namespace Germania\Salesmen;

trait SalesmanIntereptorsTrait SalesmanProviderTrait
{
    use SalesmanProviderTrait;


    /**
     * Sets the Salesman ID.
     *
     * @var     int|string $salesman_id
     * @return  self
     */
    public function setSalesmanId( $salesman_id )
    {
        $this->salesman_id = $salesman_id;
        return $this;
    }
}

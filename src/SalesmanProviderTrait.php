<?php
namespace Germania\Salesmen;

trait SalesmanProviderTrait
{

    public $salesman_id;

    /**
     * Returns the Salesman ID.
     *
     * @return int|string
     */
    public function getSalesmanId()
    {
        return $this->salesman_id;
    }
}

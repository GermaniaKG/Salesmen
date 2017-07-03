<?php
namespace Germania\Salesmen;

interface SalesmanProviderInterface
{

    /**
     * Returns the Salesman ID.
     *
     * @return int|string
     */
    public function getSalesmanId();
}

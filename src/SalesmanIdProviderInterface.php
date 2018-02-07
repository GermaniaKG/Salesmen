<?php
namespace Germania\Salesmen;

interface SalesmanIdProviderInterface
{

    /**
     * Returns the Salesman ID.
     *
     * @return int|string
     */
    public function getSalesmanId();
}

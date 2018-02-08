<?php
namespace Germania\Salesmen;

class Salesman extends SalesmanAbstract implements SalesmanInterface
{


    public function __toString()
    {
        return $this->getDisplayName();
    }









}

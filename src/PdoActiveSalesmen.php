<?php
namespace Germania\Salesmen;

use Psr\Container\ContainerInterface;
use Germania\Salesmen\Exceptions\SalesmanNotFoundException;

class PdoActiveSalesmen extends PdoAllSalesmen
{

    public function __construct (\PDO $pdo, $table, SalesmanInterface $salesman = null)
    {
        parent::__construct( $pdo, $table, $salesman);

        $this->salesmen = iterator_to_array( new ActiveSalesmanFilterIterator( $this->getIterator()) );
    }

}

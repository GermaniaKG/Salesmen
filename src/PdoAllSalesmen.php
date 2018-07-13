<?php
namespace Germania\Salesmen;

use Psr\Container\ContainerInterface;
use Germania\Salesmen\Exceptions\SalesmanNotFoundException;
use Germania\Salesmen\Exceptions\SalesmanDatabaseException;

class PdoAllSalesmen implements ContainerInterface, \IteratorAggregate, \Countable
{
    /**
     * @var \PDO
     */
    public $pdo;

    /**
     * @var string
     */
    public $table = "salesmen";

    /**
     * @var SalesmanInterface[]
     */
    public $salesmen = array();

    /**
     * @param \PDO                   $pdo      PDO handler
     * @param string                 $table    The table name to use
     * @param SalesmanInterface|null $salesman Class or object template to work with
     */
    public function __construct (\PDO $pdo, $table, SalesmanInterface $salesman = null)
    {
        $this->table    = $table;
        $this->pdo      = $pdo;

        // aussendienst_nummer ID is listed twice here in order to use it with FETCH_UNIQUE as array key
        $sql = "SELECT
        aussendienst_nummer,
        aussendienst_nummer          AS salesman_id,
        aussendienst_vorname         AS first_name,
        aussendienst_nachname        AS last_name,
        aussendienst_retailer_number AS retailer_number,
        aussendienst_email           AS email,
        user_id,
        is_active

        FROM {$this->table}

        WHERE 1

        ORDER BY
        aussendienst_nachname ASC,
        aussendienst_vorname ASC,
        aussendienst_nummer ASC";

        $this->stmt = $pdo->prepare( $sql );

        $this->stmt->setFetchMode( \PDO::FETCH_CLASS, $salesman ? get_class($salesman) : Salesman::class );

        if (!$this->stmt->execute()):
            throw new SalesmanDatabaseException("PdoAllSalesmen: Could not execute SQL query");
        endif;

        $this->salesmen = $this->stmt->fetchAll( \PDO::FETCH_UNIQUE);

    }


    /**
     * @implements ContainerInterface
     */
    public function has ($aussendienst_nummer) {
        if ($aussendienst_nummer instanceOf SalesmanIdProviderInterface) {
            $aussendienst_nummer = $aussendienst_nummer->getSalesmanId();
        }
        return array_key_exists($aussendienst_nummer, $this->salesmen);
    }


    /**
     * @implements ContainerInterface
     */
    public function get ($aussendienst_nummer) {
        if ($aussendienst_nummer instanceOf SalesmanIdProviderInterface) {
            $aussendienst_nummer = $aussendienst_nummer->getSalesmanId();
        }

        if (!$this->has($aussendienst_nummer)) {
            $msg = sprintf("Could not find Salesman with ADM-Nummer '%s'", $aussendienst_nummer);
            throw new SalesmanNotFoundException( $msg );
        }

        return $this->salesmen[$aussendienst_nummer];
    }


    /**
     * @return Iterator
     */
    public function getIterator()
    {
        return new \ArrayIterator( $this->salesmen );
    }


    /**
     * @return int
     */
    public function count()
    {
        return count( $this->salesmen );
    }
}

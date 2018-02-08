<?php
namespace Germania\Salesmen;

use Psr\Container\ContainerInterface;

class PdoActiveSalesmen implements ContainerInterface, \IteratorAggregate, \Countable
{
    /**
     * @var \PDO
     */
    public $pdo;

    public $table = "salesmen";

    public $array = array();

    public function __construct (\PDO $pdo, $table, SalesmanInterface $salesman = null)
    {
        $this->table    = $table;
        $this->pdo      = $pdo;

        // aussendienst_nummer ID is listed twice here in order to use it with FETCH_UNIQUE as array key
        $sql = "SELECT
        aussendienst_nummer,
        aussendienst_nummer as salesman_id,
        aussendienst_vorname as first_name,
        aussendienst_nachname as last_name,
        aussendienst_retailer_number as retailer_number,
        aussendienst_email as email,
        user_id,
        is_active

        FROM {$this->table}

        WHERE is_active > 0

        ORDER BY
        aussendienst_nachname ASC,
        aussendienst_vorname ASC,
        aussendienst_nummer ASC";

        $this->stmt = $pdo->prepare( $sql );

        $this->stmt->setFetchMode( \PDO::FETCH_CLASS, $salesman ? get_class($salesman) : Salesman::class );

        $bool = $this->stmt->execute();

        $this->array = $this->stmt->fetchAll( \PDO::FETCH_UNIQUE);
    }


    public function has ($aussendienst_nummer) {
        return array_key_exists($aussendienst_nummer, $this->array);
    }


    public function get ($aussendienst_nummer) {
        if (!$this->has($aussendienst_nummer)) {
            $msg = sprintf("Could not find Salesman with ADM-Nummer '%s'", $aussendienst_nummer);
            throw new SalesmanNotFoundException( $msg );
        }

        return $this->array[$aussendienst_nummer];
    }

    public function getIterator()
    {
        return new \ArrayIterator( $this->array );
    }

    public function count()
    {
        return count( $this->array );
    }
}

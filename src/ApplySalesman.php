<?php
namespace Germania\Salesmen;

class ApplySalesman
{

    /**
     * @var Callable
     */
    public $salesman_factory;

    /**
     * @var SalesmanInterface
     */
    public $salesman_fallback;


    /**
     * @param callable $salesman_factory Callable that takes a Salesman ID that should return a SalesmanInterface instance.
     */
    public function __construct( callable $salesman_factory, SalesmanInterface $salesman_fallback = null )
    {
        $this->salesman_factory  = $salesman_factory;
        $this->salesman_fallback = $salesman_fallback;
    }


    /**
     * @param  SalesmanIdProviderInterface|StdClass $aggregator Object that provides a salesman_id
     * @return bool
     */
    public function __invoke( $aggregator )
    {


        // Prepare callable
        $salesman_factory = $this->salesman_factory;


        // Add salesman proporty if not exists
        if (!isset($aggregator->salesman)):
            $aggregator->salesman = null;
        endif;


        // If salesman_id is available
        if ($aggregator instanceOf SalesmanIdProviderInterface):
            $aggregator->salesman = $salesman_factory( $aggregator->getSalesmanId(), $this->salesman_fallback );

        elseif (isset($aggregator->salesman_id)):
            $aggregator->salesman = $salesman_factory( $aggregator->salesman_id, $this->salesman_fallback );

        // Salesman can not be set
        else:
            return false;
        endif;

        return true;
    }
}

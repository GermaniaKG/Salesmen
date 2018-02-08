<?php
namespace Germania\Salesmen;

/**
 * IteratorApplySalesman
 *
 * Usage:
 *
 *     <?php
 *     $salesman_name_factory = function( $retailer ) { return "First name" };
 *
 *     $retailers = new \ArrayIterator([ instance1, instance2 ]);
 *     iterator_apply($retailers, new IteratorApplySalesman( $salesman_name_factory ), [ $retailers ]);
 */
class IteratorApplySalesman
{

    /**
     * @var Callable
     */
    public $salesman_factory;


    /**
     * @var Callable
     */
    public $apply;


    /**
     * @param callable          $salesman_factory  Callable that takes a Salesman ID and returns a Salesman instance.
     * @param SalesmanInterface $salesman_fallback Optional SalesmanInterface fallback instance
     * @param callable          $apply             Optional Callable that takes the current item on iteration.
     */
    public function __construct( callable $salesman_factory, SalesmanInterface $salesman_fallback = null, callable $apply = null )
    {
        $this->salesman_factory = $salesman_factory;
        $this->apply = $apply ?: new ApplySalesman( $salesman_factory, $salesman_fallback );
    }


    /**
     * Must return TRUE, according to PHP's iterator_applay.
     *
     * @see  http://php.net/manual/de/function.iterator-apply.php
     */
    public function __invoke( \Traversable $iterator )
    {

        $current = ($iterator instanceOf \IteratorAggregate)
        ? $iterator->getIterator()->current()
        : $iterator->current();

        // Perform
        $apply = $this->apply;
        $apply( $current );

        // Must return true for iterator_apply
        return true;
    }


}

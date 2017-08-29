<?php
namespace Germania\Salesmen;

class SalesmanFilterIterator extends \FilterIterator
{

    /**
     * @var mixed
     */
    public $salesman_filter;


    /**
     * @param \Traversable $collection      Collection of SalesmanProviderInterface
     * @param array|int    $salesman_filter The Salesman ID to filter for
     */
    public function __construct( \Traversable $collection, $salesman_filter )
    {
        // Allow for getSalesmanId
        $this->salesman_filter = $salesman_filter instanceOf SalesmanProviderInterface
        ? $salesman_filter->getSalesmanId()
        : $salesman_filter;

        // Cast to array
        if (!is_array($this->salesman_filter)) {
            $this->salesman_filter = array( $this->salesman_filter );
        }

        // Take care of Traversable's two faces,
        // since both IteratorAggregate and Iterator implement Traversable
        parent::__construct( $collection instanceOf \IteratorAggregate ? $collection->getIterator() : $collection );

    }


    public function accept()
    {
        $item = $this->getInnerIterator()->current();

        // Disclose items not implementing SalesmanProviderInterface
        if (!$item instanceOf SalesmanProviderInterface) {
            return false;
        }

        // Cast to array
        $item_salesman_id = $item->getSalesmanId();
        if (!is_array($item_salesman_id)) {
            $item_salesman_id = array( $item_salesman_id );
        }

        // Check intersection
        return !empty(array_intersect($this->salesman_filter, $item_salesman_id));
    }
}

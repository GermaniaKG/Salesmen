<?php
namespace Germania\Salesmen;

class ActiveSalesmanFilterIterator extends \FilterIterator
{

    /**
     * @var boolean
     */
    public $active_flag = true;

    /**
     * @param \Traversable $collection      Collection of SalesmanIdProviderInterface
     * @param bool $active_flag
     */
    public function __construct( \Traversable $collection, $active_flag = true )
    {
        // Take care of Traversable's two faces,
        // since both IteratorAggregate and Iterator implement Traversable
        parent::__construct( $collection instanceOf \IteratorAggregate ? $collection->getIterator() : $collection );
    }

    public function accept()
    {
        $item = $this->getInnerIterator()->current();

        // Disclose items not implementing SalesmanIdProviderInterface
        if (!$item instanceOf SalesmanIdProviderInterface) {
            return false;
        }

        return $item->isActive() == $this->active_flag;

    }

}

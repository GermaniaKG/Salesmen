<?php
namespace Germania\Salesmen;

trait SalesmanIdAwareTrait
{
    use SalesmanIdProviderTrait;

    /**
     * Sets the Salesman ID.
     *
     * @var     int|string|SalesmanIdProviderInterface $salesman
     * @return  self
     */
    public function setSalesmanId( $salesman )
    {
        if ($salesman instanceOf SalesmanIdProviderInterface):
            $this->salesman_id = $salesman->getSalesmanId();
        else:
            $this->salesman_id = $salesman;
        endif;

        return $this;
    }
}

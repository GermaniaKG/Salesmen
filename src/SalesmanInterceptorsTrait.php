<?php
namespace Germania\Salesmen;

trait SalesmanInterceptorsTrait
{
    use SalesmanProviderTrait;


    /**
     * Sets the Salesman ID.
     *
     * @var     int|string|SalesmanProviderInterface $salesman
     * @return  self
     */
    public function setSalesmanId( $salesman )
    {
        if ($salesman instanceOf SalesmanProviderInterface):
            $this->salesman_id = $salesman->getSalesmanId();
        else:
            $this->salesman_id = $salesman;
        endif;

        return $this;
    }
}

<?php
namespace tests;

use Prophecy\Argument;

trait MockPdoTrait
{

    /**
     * @param  bool  $execute_result PDOStatement execution result
     * @param  array $fetch_result   PDOStatement fetch result
     * @return PDOStatement mock
     */
    protected function createMockPdoStatement( $execute_result, $fetch_result )
    {
        $stmt = $this->prophesize(\PDOStatement::class);

        $stmt->setFetchMode( Argument::type('integer'), Argument::type('string') )->willReturn( true );
        
        #$stmt->execute( Argument::type( 'array') )->willReturn( $execute_result );
        $stmt->execute( Argument::any() )->willReturn( $execute_result );

        # $stmt->fetch( )->willReturn( $fetch_result );
        # $stmt->fetchAll( Argument::type('int') )->willReturn( $fetch_result );
        $stmt->fetchAll(Argument::type('integer'), Argument::type('string') )->willReturn( $fetch_result );
        $stmt->fetchObject( Argument::type('string') )->willReturn( $fetch_result );
        
        $stmt->errorInfo()->willReturn([
            "XXXXX",
            "YYYYY",
            "Mocked PDOStatement execution error"
        ]);
        return $stmt->reveal();
    }


    /**
     * @param  \PDOStatement|false $stmt_mock PDOStatement or mock or FALSE
     * @return \PDO mock
     */
    protected function createMockPdo( $stmt_mock )
    {
        $pdo = $this->prophesize(\PDO::class);
        $pdo->prepare( Argument::type('string') )->willReturn( $stmt_mock );
        return $pdo->reveal();
    }

}
<?php

namespace Tests\Unit;

use App\Domain\Service\ShortestPathService;
use Tests\TestCase;

class FindPathTest extends TestCase
{
    public function test_should_insert_into_input_file()
    {
        $file = 'assets/input.csv';
        $route = 'CGR,GRU,55';

        $service = new ShortestPathService($file, $route);

        $routesBeforeInsertion = array_map('str_getcsv', file(base_path($file)));

        $service->insert();

        $routesAfterInsertion = array_map('str_getcsv', file(base_path($file)));

        $this->assertNotEquals($routesBeforeInsertion, $routesAfterInsertion);
        $this->assertCount(count($routesBeforeInsertion) + 1, $routesAfterInsertion);
    }

    public function test_should_not_insert_invalid_format()
    {
        $file = 'assets/input.csv';
        $route = 'CGR,GRU-55';

        $service = new ShortestPathService($file, $route);

        $routesBeforeInsertion = array_map('str_getcsv', file(base_path($file)));

        $this->expectException(\ErrorException::class);

        $service->insert();

        $routesAfterInsertion = array_map('str_getcsv', file(base_path($file)));

        $this->assertEquals($routesBeforeInsertion, $routesAfterInsertion);
    }

    public function test_using_graph_case_should_return_A_B_D_F()
    {
        $file = 'assets/graph-test-case.txt';
        $route = 'A-F';

        $service = new ShortestPathService($file, $route);

        $bestRoute = $service->handle();

        $this->assertEquals('Best route: A - B - D - F > $11', $bestRoute);
    }

    public function test_using_graph_case_should_return_A_E_G()
    {
        $file = 'assets/graph-test-case.txt';
        $route = 'A-G';

        $service = new ShortestPathService($file, $route);

        $bestRoute = $service->handle();

        $this->assertEquals('Best route: A - E - G > $12', $bestRoute);
    }

    public function test_using_graph_case_should_return_F_D_E_C()
    {
        $file = 'assets/graph-test-case.txt';
        $route = 'F-C';

        $service = new ShortestPathService($file, $route);

        $bestRoute = $service->handle();

        $this->assertEquals('Best route: F - D - E - C > $12', $bestRoute);
    }
}

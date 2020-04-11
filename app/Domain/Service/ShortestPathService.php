<?php

namespace App\Domain\Service;

class ShortestPathService
{
    private const ORIGIN = 0;
    private const DESTINATION = 1;
    private const COST = 2;

    private $routes;
    private $visitedNodes = [];

    private $file;
    private $route;

    public function __construct(string $file, string $route)
    {
        $this->file  = $file;
        $this->route = $route;
    }

    public function handle()
    {
        $this->routes = array_map('str_getcsv', file(base_path($this->file)));

        $nodes = $this->getNodes();

        [$initialNode, $finalNode] = explode('-', $this->route);

        $trace       = [];
        $currentNode = $initialNode;
        $nodes       = $this->setInitialDistances($initialNode, $nodes);

        $this->visitedNodes[$currentNode] = true;

        while ($currentNode <> $finalNode) {
            $neighbors = $this->getNeighborsAndDistances($currentNode);

            foreach ($neighbors as $neighbor => $distance) {
                if ($nodes[$neighbor] > $nodes[$currentNode] + $distance) {
                    $nodes[$neighbor] = $nodes[$currentNode] + $distance;
                    $trace[$neighbor] = $currentNode;
                }
            }

            $currentNode = $this->getLowestValueNeighbor($nodes);

            $this->visitedNodes[$currentNode] = true;
        }

        return $this->print($trace, $finalNode, $nodes[$currentNode]);
    }

    private function getNodes(): array
    {
        //Putting all possible destinations, treated as nodes, in an unique array
        $nodes = [];
        foreach ($this->routes as $route) {
            $nodes[] = $route[self::ORIGIN];
            $nodes[] = $route[self::DESTINATION];
        }

        return array_unique($nodes);
    }

    private function setInitialDistances(string $initialNode, array $nodes): array
    {
        //Setting infinite value for nodes I do not know yet. InitialNode starts as 0
        $distances = [];
        foreach ($nodes as $node) {
            $distances[$node] = PHP_INT_MAX;
        }

        $distances[$initialNode] = 0;

        return $distances;
    }

    private function getNeighborsAndDistances(string $node): array
    {
        //Returning all neighbors (or destinations) from node, based on the input, treated as routes
        $neighbors = [];
        foreach ($this->routes as $route) {
            if ($route[self::ORIGIN] === $node) {
                $neighbors[$route[self::DESTINATION]] = $route[self::COST];
            }
        }

        return $neighbors;
    }

    private function getLowestValueNeighbor(array $nodes)
    {
        //Getting the next minimum node from unvisitedNodes
        $unvisitedNodes = array_diff_key($nodes, $this->visitedNodes);
        $minDistance    = min($unvisitedNodes);

        return array_search($minDistance, $unvisitedNodes);
    }

    private function print(array $trace, string $finalNode, int $cost)
    {
        //Printing the trace back
        while (isset($trace[$finalNode])) {
            $previousNode[] = $finalNode;
            $finalNode      = $trace[$finalNode];
        }

        $previousNode[] = $finalNode;

        return 'Best route: ' . implode(' - ', array_reverse($previousNode)) . " > $$cost";
    }

    public function insert()
    {
        [$origin, $destination, $distance] = explode(',', $this->route);

        $this->routes = array_map('str_getcsv', file(base_path($this->file)));

        $newRoute = explode(',', $this->route);

        array_push($this->routes, $newRoute);

        $fp = fopen(base_path($this->file), 'w');

        foreach ($this->routes as $route) {
            fputcsv($fp, $route);
        }

        fclose($fp);
    }
}
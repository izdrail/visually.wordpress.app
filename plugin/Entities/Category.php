<?php

namespace Visually\Entities;


use Illuminate\Support\Collection;

/**
 * Class Category
 * @package App\Entities
 */
class Category{


    protected $category;

    protected $results;


    /**
     * @method setCategory
     * @param mixed $category
     */
    public function setCategory( int $category ) {
        $this->category = $category;
    }

    /**
     * @method getCategory
     * @return int
     */
    public function getCategory() {
        return $this->category;
    }


    /**
     * @method setResults
     * @param array $results
     * @return Category
     */
    public function setResults(array $results):Category{

        $this->results =  collect([]);

        foreach ($results as $result){

            if(is_object($result)){


                $this->results->push(new Post($result));
            }

        }

        return $this;

    }

    /**
     * @method getResults
     * @return mixed
     */
    public function getResults():Collection{

        return $this->results;

    }


}

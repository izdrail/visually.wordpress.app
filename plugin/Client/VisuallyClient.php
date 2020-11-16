<?php
/**
 * @author Stefan Izdrail
 **/


namespace Visually\Client;


use Visually\Entities\Category;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Visually\Entities\Post;


/**
 * Class VisuallyClient
 * @package App\Clients
 */
class VisuallyClient {

    /**
     * @const API_BASE
     */
    const API_BASE = 'https://a.visual.ly';
    /**
     * @const AJAX_ENDPOINT
     */
    const AJAX_ENDPOINT = '/ajax/home-page';


    /**
     * @var string[]
     */
    protected $categories = [

        54 => 'Business',
        42 => 'Computers',
        45 => 'Economy',
        15707 => 'Gaming',
        50 => 'Science',
        1104 => 'Social Media',
        46 => 'Technology',


    ];

	/**
	 * Extract
	 * @method extract
	 * @return array
	 * @throws TransportExceptionInterface
	 * @throws \Exception
	 */
    public function extract(): array {

        $client = HttpClient::create();

        $collection = collect([]);

        foreach ($this->categories as $key => $value){

	        $response = $client->request('GET', self::API_BASE . self::AJAX_ENDPOINT. $this->setPage(1) . $this->setCategory($key), [
		        'headers' => [
			        'Origin' => 'https://visual.ly',
			        'Accept' => 'application/json, text/javascript, */*; q=0.01',
		        ],
	        ]);

	        if($response->getStatusCode() == 200){

		        try {

			        $results = json_decode($response->getContent( true ));

			        foreach ($results->results as $post){

				        $post = new Post($post, $value);

				        $post->commit();

			        }


		        } catch ( ClientExceptionInterface $e ) {
		        	throw new \Exception($e->getMessage());
		        } catch ( RedirectionExceptionInterface $e ) {
			        throw new \Exception($e->getMessage());
		        } catch ( ServerExceptionInterface $e ) {
			        throw new \Exception($e->getMessage());
		        } catch ( TransportExceptionInterface $e ) {
			        throw new \Exception($e->getMessage());
		        }
	        }


        }

        return $collection->toArray();

    }

    /**
     * @method setPage
     * @param int $page
     *
     * @return string
     */
    private function setPage(int $page){
        return '?page='.$page;
    }

    /**
     * @method setCategory
     * @param int $category
     *
     * @return string
     */
    private function setCategory(int $category){
        return '&category='.$category;
    }

    /**
     * @param string $url
     */
    public function extractInfographic(string $url){

    }

}

<?php

namespace Visually\Entities;


use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;



/**
 * Class Post
 * @package Visually\Entities
 */
class Post {

	public $object;

	protected $title;

	protected $content;

	protected $excerpt;

	protected $image;

	protected $url;

	protected $type;

	protected $category;

	/**
	 * Post constructor.
	 *
	 * @param \StdClass $object
	 * @param string $category
	 *
	 * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
	 */
	public function __construct( \StdClass $object, string $category ) {

		$this->object = $object;

		$this->visitInfoGraphicPage();

		$this->category = $category;

	}
	/**
	 * @method getUrl
	 * @return mixed
	 */
	protected function getUrl() {

		return $this->object->url;

	}

	/**
	 * @method getTitle
	 * @return mixed
	 */
	protected function getTitle() {

		return $this->object->igTitle;

	}

	/**
	 * @method getImage
	 * @return mixed
	 */
	protected function getLargeImage() {

		return str_replace('_w900_h600', '', $this->object->imgSrc);

	}


	/**
	 * @method getSmallImage
	 * @return mixed
	 */
	protected function getSmallImage() {

		return $this->object->imgSrc;

	}

	/**
	 * @method getExcerpt
	 * @param Crawler $crawler
	 * @return Post
	 */
	protected function getExcerpt(Crawler $crawler) {

		$excerpt = '';

		try{

			$excerpt = $crawler->filter('span.short-description')->text();

		}catch (\Exception $exception){

		}

		$this->excerpt =   $excerpt;

		return $this;
	}

	/**
	 * @method getContent
	 * @param Crawler $crawler
	 * @return Post
	 */
	protected function getContent(Crawler $crawler){

		$content = '';

		try{

			$content = $crawler->filter('p.redesign-transcript-content')->text();

		}catch (\Exception $exception){

		}
		$this->content = $content;

		return $this;

	}

	/**
	 * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
	 */
	protected function visitInfoGraphicPage() {

		$client = HttpClient::create();

		$response = $client->request('GET', $this->getUrl(), [
			'headers' => [
				'Origin' => 'https://visual.ly',
			],
		]);

		if($response->getStatusCode() == 200){

			try {

				$content = $response->getContent();

				$crawler = new Crawler($content);

				$this->getExcerpt($crawler);

				$this->getContent($crawler);


			} catch ( ClientExceptionInterface $e ) {
			} catch ( RedirectionExceptionInterface $e ) {
			} catch ( ServerExceptionInterface $e ) {
			} catch ( TransportExceptionInterface $e ) {
			}




		}


	}

	/**
	 * @method buildPostContent
	 * @return string
	 */
	protected function buildPostContent(){

		$image = "<center><img class='text-center' src='{$this->getLargeImage()}' alt='{$this->getTitle()}' /></center>";

		return "<h3>{$this->excerpt}</h3> <br /> <br /> {$image} <br /> <br /> {$this->content}";

	}


	/**
	 * @method toArray
	 * @return array
	 */
	public function toArray() {

		return (array) $this->object;

	}

	/**
	 * Sets the post image
	 * @method @setImage
	 * @param $image_url
	 * @param $post_id
	 */
	protected function setPostImage($image_url, $post_id)
	{
		$upload_dir = wp_upload_dir();
		$image_data = file_get_contents($image_url);
		$filename = basename($image_url);
		if (wp_mkdir_p($upload_dir['path']))
			$file = $upload_dir['path'] . '/' . $filename;
		else
			$file = $upload_dir['basedir'] . '/' . $filename;
		file_put_contents($file, $image_data);

		$wp_filetype = wp_check_filetype($filename, null);
		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title' => sanitize_file_name($filename),
			'post_content' => '',
			'post_excerpt' => $this->excerpt,
			'post_status' => 'inherit'
		);
		$attach_id = wp_insert_attachment($attachment, $file, $post_id);
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata($attach_id, $file);
		wp_update_attachment_metadata($attach_id, $attach_data);
		set_post_thumbnail($post_id, $attach_id);
	}


	/**
	 * Commits the post to database
	 * @method commit
	 */
	public function commit() {

		$category = get_category_by_slug('infographics');

		$data = array(
			'post_title' => $this->getTitle(),
			'post_content' => $this->buildPostContent(),
			'post_status' => 'publish',
			'post_author' => 1,
			'post_category' => array($category->term_id)
		);
		///search for post
		$args = array("s" => $this->getTitle());

		$query = get_posts($args);

		$post = wp_insert_post($data);

		$this->setPostImage($this->getSmallImage(), $post);


	}

}

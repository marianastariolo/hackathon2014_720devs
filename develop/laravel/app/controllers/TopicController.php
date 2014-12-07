<?php

class TopicController extends \BaseController {

	protected $layout = 'layout.master';

	//Google API key
	private $google_api_key = "AIzaSyBUsuVB1YULi0Zmmjr4L0hCrDSrpBKzT-U";

	private $view_params = array();
	
	public function __construct(){

		$this->view_params["google_api_key"] = $this->google_api_key;
	}

	/**
	* First step is asking the user what he wants to learn
	*/
	public function getIndex()
	{
		$this->layout = View::make( "topic.step1", $this->view_params );
	}

	/***
	* In this step we refine the search with some help from the user
	*/
	public function postStep2(){
		/**
		TODO: securing form: http://laravel.com/docs/4.2/html
		*/
		$subject = Input::get("subject");
		$mid = Input::get("mid");
		if(empty($subject)){
			return Redirect::to('/');
		}
		
		$client = new Google_Client();
		$client->setDeveloperKey( $this->google_api_key );

		/**
		YouTube videos
		*/
		//This will be the first videos to show, related directly to the topic
		//but searching for terms related to education
		$videos = $this->getFromYoutube( "learn|education|how to|tutorial|course", $mid, $client );
		
		//Now I'll search for videos related to the search term 
		//related to education (/m/028xmlk) and hobbies (/m/05cglf6) topic.
		$videos = array_merge( $videos, $this->getFromYoutube( $subject, "/m/028xmlk", $client ) );
		$videos = array_merge( $videos, $this->getFromYoutube( $subject, "/m/05cglf6", $client ) ); 

		$this->view_params["videos"] = $videos;

		/**
		Books related to topic
		*/
		$this->getBooks( array($mid) );

		/**
		Films related to topic
		*/
		$this->getFilms( array($mid) );

		$this->view_params["subject"] = $subject;
		

		$this->layout = View::make( "topic.show", $this->view_params );
	}

	/**
	* Get youtube videos related to a topic from Freebase
	*/
	private function getFromYoutube( $search_term, $topicId, Google_Client $client ){
		if(empty($topicId)){
			return;
		}

		$youtube_api = new YouTubeReader($client);

		//I search for videos related to the topic and bring all the topics of those videos
		//I search for learning resources
		$params = array(
			'q' 			=> $search_term,
			'topicId'		=> $topicId,
			'maxResults' 	=> 20,
			'type' 			=> 'video'
		);
		$videos = $youtube_api->search($params,'id,snippet,topicDetails');
		
		return ( empty( $videos["items"] )? array() : $videos["items"] );
	}

	/**
	* Get books from google books api, first it searches in freebase
	*/
	private function getBooks($topicIds){
		if(empty($topicIds)){
			return;
		}

		$freebase = App::make("RESTreader");
		$freebase->set_endpoint( "https://www.googleapis.com/freebase/v1/search" );
		//get all the topics the user has selected
		$params = array(
			'query' 	=> "",
			'key' 		=> $this->google_api_key,
			'filter'  	=> "(all type:/book/book subject:". implode(" subject:",$topicIds) .")",
			'limit'		=> 10
		);
		$freebase->get($params);
		$result = $freebase->resultArray();
		
		$this->view_params["books"] = $result["result"];
	}

	/**
	* Get books from google books api, first it searches in freebase
	*/
	private function getFilms($topicIds){
		if(empty($topicIds)){
			return;
		}

		$freebase = App::make("RESTreader");
		$freebase->set_endpoint( "https://www.googleapis.com/freebase/v1/search" );
		//get all the topics the user has selected
		$params = array(
			'query' 	=> "",
			'key' 		=> $this->google_api_key,
			'filter'  	=> "(all type:/film/film subject:". implode(" subject:",$topicIds) .")",
			'limit'		=> 10
		);
		$freebase->get($params);
		$result = $freebase->resultArray();
		
		$this->view_params["films"] = $result["result"];
	}

}
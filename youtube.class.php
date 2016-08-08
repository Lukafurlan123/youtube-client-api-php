<?php

class Youtube {

    var $api_list = array('videos' => 'https://www.googleapis.com/youtube/v3/videos',
                          'playlists' => 'https://www.googleapis.com/youtube/v3/playlists',
                          'playlistItems' => 'https://www.googleapis.com/youtube/v3/playlistItems',
                          'search' => 'https://www.googleapis.com/youtube/v3/search',
                          'channels' => 'https://www.googleapis.com/youtube/v3/channels',
                          'activities' => 'https://www.googleapis.com/youtube/v3/activities');

    private $api_name;
    private $api_key;
    private $youtube_state = "encoded";
    private $youtube_id;
    private $youtube_part = "snippet";

    /**
     * Youtube constructor. Sets api key on file load
     * @param array $data
     * @throws Exception
     */
    public function __construct($data)
    {
        if(!is_array($data)) {
            throw new Exception('You must put your youtube api key inside an array');
        }
        if(empty($data['apiKey'])) {
            throw new Exception('You must insert youtube api key');
        }
        $this->api_key = $data['apiKey'];
    }

    /**
     * Sets api that you wish to use
     * @param $api
     * @throws Exception
     */
    public function setApiName($api)
    {
        if(empty($api) || !array_key_exists($api, $this->api_list)) {
            throw new Exception('Invalid api name');
        }
        $this->api_name = $api;
    }

    /**
     * Sets state of returned data. Either encoded or decoded
     * @param $state
     * @throws Exception
     */
    public function setYoutubeState($state)
    {
        if($state != ('encoded' || 'decoded')) {
            throw new Exception('Please choose either encoded or decoded state');
        }
        $this->youtube_state = $state;
    }

    /**
     * Sets ID of channel ||video or what ever you want to grab
     * @param $id
     * @throws Exception
     */
    public function setYoutubeId($id)
    {
        if(empty($id)) {
            throw new Exception('Please insert id');
        }
        $this->youtube_id = $id;
    }

    /**
     * Sets part which you want to grab from youtubes database
     * @param $part
     * @throws Exception
     */
    public function setYoutubePart($part)
    {
        if(empty($part)) {
            throw new Exception('Please insert part name');
        }
        $this->youtube_part = $part;
    }

    /**
     * Executes script and fetches data from google website
     * @return mixed
     * @throws Exception
     */
    public function execute()
    {
        if(empty($this->api_key) || empty($this->api_name) || empty($this->youtube_state) || empty($this->youtube_id) || empty($this->youtube_part)) {
            throw new Exception('Please set all required data before executing');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->buildUrl(['id' => $this->youtube_id, 'part' => $this->youtube_part, 'key' => $this->api_key]));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $return = curl_exec($ch);
        curl_close($ch);
        return $this->youtube_state == 'decoded' ? json_decode($return, true) : $return;
    }

    /**
     * Builds url that is then used with curl to get data from youtube
     * @param $data
     * @return string
     */
    public function buildUrl($data)
    {
        return $this->api_list[$this->api_name].'?'.http_build_query($data);
    }

    /**
     * Returns youtube url
     * @return string
     * @throws Exception
     */
    public function getYoutubeUrl()
    {
        if(empty($this->api_key) || empty($this->api_name) || empty($this->youtube_state) || empty($this->youtube_id) || empty($this->youtube_part)) {
            throw new Exception('Please set all required data before grabbing youtube url');
        }
        return $this->buildUrl(['id' => $this->youtube_id, 'part' => $this->youtube_part, 'key' => $this->api_key]);
    }



}

?>
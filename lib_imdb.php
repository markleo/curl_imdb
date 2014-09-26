<?php 
class imdb_getter 
{
	private $ch;
	private $page;
	private $data;

	public function __construct($url) 
	{
		$this->ch = curl_init();
	  	curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
	}

	public function exec() 
	{
		$this->page = curl_exec($this->ch);
		curl_close($this->ch);

		$regex = '/<span class="itemprop" itemprop="name">(.*)<\/span>/';
		preg_match($regex, $this->page, $match);
		$data['title'] = $match[1];
		
		$regex = '/<a href="\/year\/(.*)\/\?ref_=tt_ov_inf">(.*)<\/a>/';
		preg_match($regex, $this->page, $match);
		$data['year'] = $match[1];

		$regex = '/<meta itemprop="contentRating" content="(.*)" \/>/';
		preg_match($regex, $this->page, $match);
		$data['grene'] = $match[1];

		$regex = '/<a href="\/genre\/(.*)\?ref_=tt_ov_inf" >/';
		preg_match_all($regex, $this->page, $match);
		$data['category'] = $match[1];

		$regex = '/<link rel=\'image_src\' href="(.*)">/';
		preg_match($regex, $this->page, $match);
		$data['thumb'] = $match[1];

		$regex = '/\/\?ref_=tt_ov_dr" itemprop=\'url\'><span class="itemprop" itemprop="name">(.*)<\/span><\/a>/';
		preg_match($regex, $this->page, $match);
		$data['director'] = $match[1];

		$regex = '/\/\?ref_=tt_ov_st" itemprop=\'url\'><span class="itemprop" itemprop="name">(.*)<\/span><\/a>/';
		preg_match_all($regex, $this->page, $match);
		$data['actor'] = $match[1];

		$regex = '/<time itemprop="duration" datetime="PT(.*)M" >/';
		preg_match($regex, $this->page, $match);
		$data['duration'] = $match[1];

		$regex = '/<strong><span itemprop="ratingValue">(.*)<\/span><\/strong>/';
		preg_match($regex, $this->page, $match);
		$data['rate'] = $match[1];

		$this->data = $data;
		unset($data);
	}

	public function get_title() {
        // lấy tên phim
        return $this->data['title'];
    }
}
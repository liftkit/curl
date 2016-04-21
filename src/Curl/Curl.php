<?php


	namespace LiftKit\Curl;


	class Curl
	{
		protected $resource;

		protected $options;
		protected $url;
		protected $post;


		public function __construct ()
		{
			$this->clear();
		}


		public function clear ()
		{
			if (is_resource($this->resource)) {
				curl_close($this->resource);
			}

			$this->url       = '';
			$this->options   = array();
			$this->post      = array();
			$this->resource = null;

			return $this;
		}


		public function error ()
		{
			return curl_error($this->resource);
		}


		public function execute ()
		{
			curl_setopt($this->resource, CURLOPT_RETURNTRANSFER, true);

			if (! empty($this->post)) {
				$post_string = http_build_query($this->post, '', '&');

				curl_setopt($this->resource, CURLOPT_POST, true);
				curl_setopt($this->resource, CURLOPT_POSTFIELDS, $post_string);
			}

			foreach ($this->options as $key => $value) {
				curl_setopt($this->resource, $key, $value);
			}

			return curl_exec($this->resource);
		}


		public function info ($option = 0)
		{
			return curl_getinfo($this->resource, $option);
		}


		public function option ($key, $value)
		{
			$this->options[$key] = $value;

			return $this;
		}


		public function post ($data)
		{
			$this->post = array_merge($this->post, $data);

			return $this;
		}


		public function url ($url)
		{
			$this->clear();
			$this->resource = curl_init($url);

			return $this;
		}

	}


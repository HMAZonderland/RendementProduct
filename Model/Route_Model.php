<?php
/**
 * Class Route
 */
class Route {
	
	/**
	* URL of this Route
	* @var string
	*/
	private $url;

	/**
	* Accepted HTTP methods for this route
	* @var array
	*/
	private $methods = array('GET','POST','PUT','DELETE');

	/**
	* Target for this route, can be anything.
	* @var mixed
	*/
	private $target;

	/**
	* The name of this route, used for reversed routing
	* @var string
	*/
	private $name;

	/**
	* Custom parameter filters for this route
	* @var array
	*/
	private $filters = array();

	/**
	* Array containing parameters passed through request URL
	* @var array
	*/
	private $params = array();

    /**
     * @return string
     */
    public function getUrl() {
		return $this->url;
	}

    /**
     * @param $url
     */
    public function setUrl($url) {
		$url = (string) $url;

		// make sure that the URL is suffixed with a forward slash
		if(substr($url,-1) !== '/') $url .= '/';
		
		$this->url = $url;
	}

    /**
     * @return mixed
     */
    public function getTarget() {
		return $this->target;
	}

    /**
     * @param $target
     */
    public function setTarget($target) {
		$this->target = $target;
	}

    /**
     * @return array
     */
    public function getMethods() {
		return $this->methods;
	}

    /**
     * @param array $methods
     */
    public function setMethods(array $methods) {
		$this->methods = $methods;
	}

    /**
     * @return string
     */
    public function getName() {
		return $this->name;
	}

    /**
     * @param $name
     */
    public function setName($name) {
		$this->name = (string) $name;
	}

    /**
     * @param array $filters
     */
    public function setFilters(array $filters) {
		$this->filters = $filters;
	}

    /**
     * @return mixed
     */
    public function getRegex() {
		return preg_replace_callback("/:(\w+)/", array(&$this, 'substituteFilter'), $this->url);
	}

    /**
     * @param $matches
     *
     * @return string
     */
    private function substituteFilter($matches) {
		if (isset($matches[1]) && isset($this->filters[$matches[1]])) {
        		return $this->filters[$matches[1]];
        	}
        
        	return "([\w-]+)";
	}

    /**
     * @return mixed
     */
    public function getParameters() {
		return $this->params;
	}

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters) {
		$this->params = $parameters;
	}
}
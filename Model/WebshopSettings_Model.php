<?php
class WebshopSettings_Model extends Main_Model
{
    /**
     * @var int id
     */
    public $id;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $API_URL;
    /**
     * @var string
     */
    public $API_username;
    /**
     * @var string
     */
    public $API_key;

    public function __construct($model)
    {
        $this->name = $model->name;
        $this->API_key = $model->magento_key;
        $this->API_username = $model->magento_user;
        $this->API_URL = $model->magento_host;
        $this->id = $model->id;
    }

    public function updateWebshopSettings()
    {
        parent::__construct();

        $webshop = R::load('webshop', $this->id);
        $webshop->name = $this->name;
        $webshop->magento_key = $this->API_key;
        $webshop->magento_user = $this->API_username;
        $webshop->magento_host = $this->API_URL;
        R::store($webshop);
        $this->notification->success('De instellingen zijn aangepast.');
    }
}
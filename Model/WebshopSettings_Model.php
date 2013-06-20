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

    /**
     * @param $model
     */
    public function __construct($model)
    {
        $this->name = $model->name;
        $this->API_key = $model->magento_key;
        $this->API_username = $model->magento_user;
        $this->API_URL = $model->magento_host;
        $this->id = $model->id;
    }

    /**
     * @param $post_data
     */
    public function updateWebshopSettings($post_data)
    {
        parent::__construct();

        $webshop = R::load('webshop', $this->id);
        $webshop->name = $post_data['webshop_name'];
        $webshop->magento_key = $post_data['magento_key'];
        $webshop->magento_user = $post_data['magento_user'];
        $webshop->magento_host = $post_data['magento_host'];
        R::store($webshop);

        self::__construct($webshop);

        $this->notification->success('De instellingen zijn aangepast.');
    }
}
<?php

namespace Naif\CpanelMail\Http\Controllers;

class Cpanel
{
    
    public $url;
    public $fields;
    private $fallbackFields;
    
    /**
     * If testing, this will fake the responses
     * @var \GuzzleHttp\Handler\MockHandler
     */
    public $mock;
    
    function __construct()
    {
        $this->url = env('CPANEL_HOST') . ':' . env('CPANEL_PORT');
        $this->cleanConfig();
    }
    
    public function email()
    {
        return new CpanelEmail();
    }

    /**
     * Adiciona campos da array informada nas configurações
     *
     * @param array $fields
     */
    public function mergeFields(array $fields)
    {
        $this->fallbackFields = $this->fields;
        
        if (is_array($fields)) {
            $this->fields = array_merge($this->fields, $fields);
        }
    }
    
    public function cleanConfig()
    {
        $this->fields = [
            'cpanel_jsonapi_user'       => env('CPANEL_USERNAME'),
            'cpanel_jsonapi_apiversion' => '2',
            'cpanel_jsonapi_module'     => '',
            'cpanel_jsonapi_func'       => '',
        ];
    }
    
}
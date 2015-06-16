<?php namespace Serverfireteam\Efinance;

/**
 * Barclays eFinance Library - Main Class
 *
 * @name      barclaysefinance
 * @author    Ben Griffiths <https://github.com/BenGriffiths/barclays-efinance-api-library>
 */
class barclaysefinance
{


    /**
     * The configuration variables
     *
     * @access protected
     * @type   array
     */
    protected $configuration;


    /**
     * The configuration variables for the currently
     * set environment
     *
     * @access protected
     * @type   array
     */
    protected $configuration_current;


    /**
     * The Soap Client
     *
     * @access protected
     * @type   object
     */
    protected $soap_client;


    /**
     * The Soap data array
     *
     * @access public
     * @type   array
     */
    public $data_array = array();


    /**
     * The Soap Call return data
     *
     * @access public
     * @type   array
     */
    public $call_result;


    /**
     * List of catchable (and mostly safe) errors
     *
     * @access public
     * @type   array
     */
    public $catchable_errors = array
            (
                '603' => 'Batch not created as all notifications were rejected',
                '605' => 'No Batch found for specified BatchID and Reference combination'
            );


    /**
     * List of caught (mostly safe) errors
     *
     * @access public
     * @type   array
     */
    public $caught_errors;


    /**
     * Class Constructor
     *
     * @access public
     * @return void
     */
    public function __construct()
    {   
        $this->is_soap_installed();

        $this->load_configs();

        $this->debug($this->configuration, 'Configuration Data');
    }


    /**
     * Load the config data
     *
     * @access public
     * @return void
     */
    public function load_configs()
    {


        $this->configuration = \Config('efinance');

        $this->configuration_current = $this->configuration[$this->configuration['ENVIRONMENT']];
    }


    /**
     * Add the user credentials to the array
     *
     * @access public
     * @type   array
     */
    public function add_user_credentials()
    {
        $this->data_array['UserCredentials'] = array
        (
            'LoginName' => $this->configuration_current['USERNAME'],
            'Password'  => $this->configuration_current['PASSWORD']
        );
    }


    /**
     * Add elements to the data array
     *
     * @access public
     * @type   array
     */
    public function add_data($key = '', $data = '')
    {
        $this->data_array[$key] = $data;
    }


    /**
     * Check to see if soap is installed
     *
     * @access public
     * @return bool    Returns TRUE if soap is installed
     */
    public function is_soap_installed()
    {
        if(extension_loaded('soap'))
        {
            return true;
        }
        else
        {
            throw new exception('<strong>Soap is not installed on this server</strong>');
        }
    }


    /**
     * Print our debug information
     *
     * @access public
     * @param  mixed   $debug  The information to dump
     * @return bool
     */
    public function debug($debug = null, $title = '', $force = false)
    {
        if($this->configuration_current['DEBUG'] == true || $force == true)
        {
            echo '<pre>';

            if(!empty($debug))
            {
                echo '<strong>DEBUG: '.$title.'</strong><br /><br />';
            }

            if(is_array($debug))
            {
                print_r($debug);
            }
            elseif(is_object($debug))
            {
                var_dump($debug);
            }
            else
            {
                if(substr($debug, 0, 1) == '<')
                {
                    $dom = new \DOMDocument;
                    $dom->preserveWhiteSpace = FALSE;
                    $dom->loadXML($debug);
                    $dom->formatOutput = TRUE;
                    echo htmlentities($dom->saveXml());
                }
                else
                {
                    echo $debug;
                }
            }

            echo '</pre>';
        }
    }


    /**
     * Create the Soap Client
     *
     * @access public
     * @return void
     */
    public function create_client()
    {
        try
        {   
            $this->soap_client = new \SoapClient( storage_path() . '/app/'. $this->configuration_current['WSDL_PATH'], array('trace' => true, 'exceptions' => true));

            if(!empty($this->configuration_current['WSDL_LOCATION']))
            {
                $this->soap_client->__setLocation($this->configuration_current['WSDL_LOCATION']);
            }
        }
        catch(Exception $e)
        {
            throw new exception('<strong>Unable to create soap client ('.$e->getMessage().')</strong>');
        }

        $this->debug($this->soap_client, 'Soap Client Object');
    }


    /**
     * Show via debug, the request and response data
     *
     * @access public
     * @return void
     */
    public function debug_headers_response()
    {
        $this->debug($this->soap_client->__getLastRequestHeaders(), 'Last Request Headers');

        $this->debug($this->soap_client->__getLastRequest(), 'Last Request');

        $this->debug($this->soap_client->__getLastResponseHeaders(), 'Last Response Headers');

        $this->debug($this->soap_client->__getLastResponse(), 'Last Response');
    }


    /**
     * Check for the fields needed for this call
     *
     * @access public
     * @return void
     */
    public function check_data()
    {
    }


    /**
     * Call the function
     *
     * @access public
     * @return void
     */
    public function call()
    {
        $this->check_data();

        $this->add_user_credentials();
    }


    /**
     * Process methods required to run after the call has completed
     *
     * @access public
     * @return void
     */
    public function after_call()
    {
        $this->debug_headers_response();

        $this->debug($this->call_result, 'Soap Result');

        $this->check_result_for_errors();
    }


    /**
     * Check the result for any errors
     *
     * @access public
     * @return void
     */
    public function check_result_for_errors()
    {
        if(isset(current((array)$this->call_result)->Errors) && isset(current((array)$this->call_result)->Errors->IsError) && current((array)$this->call_result)->Errors->IsError == true)
        {
            $this->debug(current((array)$this->call_result)->Errors, 'Soap Errors', true);

            if(is_array($error_message = current((array)$this->call_result)->Errors->ErrorDetails->ErrorDetail))
            {
                $message = array();

                $code = 0;

                $throw = false;

                foreach(current((array)$this->call_result)->Errors->ErrorDetails->ErrorDetail as $error)
                {
                    $error_message = $error->Message;
                    $error_code    = $error->Code;

                    if($ocde == 0)
                    {
                        $code = $error_code;
                    }

                    $message[] =  '<strong>'.$error_message.' (Code: '.(int)$error_code.')</strong>';

                    if(!array_key_exists((int)$error_code, $this->catchable_errors))
                    {
                        $throw = true;
                    }
                }

                $message = implode(' &amp; ', $message);

                if($throw == true)
                {
                    throw new exception($message, $code);
                }
            }
            else
            {
                $error_message = current((array)$this->call_result)->Errors->ErrorDetails->ErrorDetail->Message;
                $error_code    = current((array)$this->call_result)->Errors->ErrorDetails->ErrorDetail->Code;

                if(!array_key_exists((int)$error_code, $this->catchable_errors))
                {
                    throw new exception('<strong>'.$error_message.' (Code: '.(int)$error_code.')</strong>', (int)$error_code);
                }
                else
                {
                    $this->caught_errors[(int)$error_code] = $error_message;
                }
            }
        }
    }


    /**
     * Return any caught friendly errors
     *
     * @access public
     * @return mixed   False on no errors, array of errors if exist
     */
    public function errors()
    {
        if(!empty($this->caught_errors))
        {
            return false;
        }
        else
        {
            return $this->caught_errors;
        }
    }


    /**
     * Return the results from the call
     *
     * @access public
     * @return mixed   The result of the call
     */
    public function results($type = 'array')
    {
        if($type == 'array')
        {
            return get_object_vars($this->call_result);
        }
        else
        {
            return $this->call_result;
        }
    }


}

?>
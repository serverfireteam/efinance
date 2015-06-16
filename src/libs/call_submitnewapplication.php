<?php namespace Serverfireteam\Efinance;
/**
 * Barclays eFinance Library - submitNewApplication
 *
 * @name      bef_submitNewApplication
 * @author    Ben Griffiths <https://github.com/BenGriffiths/barclays-efinance-api-library>
 */
class bef_submitNewApplication extends barclaysefinance
{


    /**
     * Proposal data array
     *
     * @access public
     * @type   array
     */
    public $build_proposal;


    /**
     * Goods data array
     *
     * @access public
     * @type   array
     */
    public $build_goods;


    /**
     * Customer data array
     *
     * @access public
     * @type   array
     */
    public $build_customer;


    /**
     * Address data array
     *
     * @access public
     * @type   array
     */
    public $build_address;


    /**
     * Prepare the initial array structures
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->build_proposal = array
        (
            'ProposalTypeCode' => '',
            'InterestRateType' => '',
            'InterestRate'     => '',
            'Term'             => '',
            'DeferralPeriod'   => '',
            'ClientReference'  => '',
            'CashPrice'        => '',
            'Deposit'          => '',
            'ThirdPartyCharge' => ''
        );

        $this->build_customer = array
        (
            'Title'        => '',
            'Forename'     => '',
            'Initial'      => '',
            'Surname'      => '',
            'EmailAddress' => ''
        );

        $this->build_address = array
        (
            'HouseNumber' => '',
            'HouseName'   => '',
            'Flat'        => '',
            'Street'      => '',
            'District'    => '',
            'Town'        => '',
            'County'      => '',
            'Postcode'    => ''
        );
    }


    /**
     * Check for the fields needed for this call
     *
     * @access public
     * @return void
     */
    public function check_data()
    {
        parent::check_data();

        if(empty($this->build_goods))
        {
            throw new exception('<strong>Data missing: Goods</strong>');
        }
    }


    /**
     * Build the Proposal data array
     *
     * @access public
     * @return void
     */
    public function build_proposal($key = '', $value = '')
    {
        if(!empty($key))
        {
            if(strtolower($key) == 'proposaltypecode')
            {
                $this->build_proposal['ProposalTypeCode'] = $value;
            }
            elseif(strtolower($key) == 'interestratetype')
            {
                $this->build_proposal['InterestRateType'] = $value;
            }
            elseif(strtolower($key) == 'interestrate')
            {
                $this->build_proposal['InterestRate'] = $value;
            }
            elseif(strtolower($key) == 'term')
            {
                $this->build_proposal['Term'] = $value;
            }
            elseif(strtolower($key) == 'deferralperiod')
            {
                $this->build_proposal['DeferralPeriod'] = $value;
            }
            elseif(strtolower($key) == 'clientreference')
            {
                $this->build_proposal['ClientReference'] = $value;
            }
            elseif(strtolower($key) == 'cashprice')
            {
                $this->build_proposal['CashPrice'] = $value;
            }
            elseif(strtolower($key) == 'deposit')
            {
                $this->build_proposal['Deposit'] = $value;
            }
            elseif(strtolower($key) == 'thirdpartycharge')
            {
                $this->build_proposal['ThirdPartyCharge'] = $value;
            }
            else
            {
                throw new exception('<strong>Unknown Proposal Key \''.$key.'\'</strong>');
            }
        }
    }


    /**
     * Build the Goods data array
     *
     * @access public
     * @return void
     */
    public function build_goods($type = '', $desc = '', $qty = 0)
    {
        if(!empty($type))
        {
            $this->build_goods[] = array
            (
                'type' => $type,
                'desc' => $desc,
                'qty'  => $qty
            );
        }
        else
        {
            throw new exception('<strong>Goods type cannot be empty</strong>');
        }
    }


    /**
     * Build the Customer data array
     *
     * @access public
     * @return void
     */
    public function build_customer($key = '', $value = '')
    {
        if(!empty($key))
        {
            if(strtolower($key) == 'title')
            {
                $this->build_customer['Title'] = $value;
            }
            elseif(strtolower($key) == 'forename')
            {
                $this->build_customer['Forename'] = $value;
            }
            elseif(strtolower($key) == 'initial')
            {
                $this->build_customer['Initial'] = $value;
            }
            elseif(strtolower($key) == 'surname')
            {
                $this->build_customer['Surname'] = $value;
            }
            elseif(strtolower($key) == 'emailaddress')
            {
                $this->build_customer['EmailAddress'] = $value;
            }
            else
            {
                throw new exception('<strong>Unknown Customer Key \''.$key.'\'</strong>');
            }
        }
    }


    /**
     * Build the Address data array
     *
     * @access public
     * @return void
     */
    public function build_address($key = '', $value = '')
    {
        if(!empty($key))
        {
            if(strtolower($key) == 'housenumber')
            {
                $this->build_address['HouseNumber'] = $value;
            }
            elseif(strtolower($key) == 'housename')
            {
                $this->build_address['HouseName'] = $value;
            }
            elseif(strtolower($key) == 'flat')
            {
                $this->build_address['Flat'] = $value;
            }
            elseif(strtolower($key) == 'street')
            {
                $this->build_address['Street'] = $value;
            }
            elseif(strtolower($key) == 'district')
            {
                $this->build_address['District'] = $value;
            }
            elseif(strtolower($key) == 'town')
            {
                $this->build_address['Town'] = $value;
            }
            elseif(strtolower($key) == 'county')
            {
                $this->build_address['County'] = $value;
            }
            elseif(strtolower($key) == 'postcode')
            {
                $this->build_address['Postcode'] = $value;
            }
            else
            {
                throw new exception('<strong>Unknown Address Key \''.$key.'\'</strong>');
            }
        }
    }


    /**
     * Call the function
     *
     * @access public
     * @return void
     */
    public function call()
    {
        parent::call();

        $this->add_data('Proposal', $this->build_proposal);

        $all_goods = array();

        foreach($this->build_goods as $goods)
        {
            $array = array
            (
                'Description' => $goods['desc'],
                'Quantity'    => $goods['qty'],
                'Type' => $goods['type']
            );
            
            $all_goods[] = $array;
        }

        $this->add_data('Goods', $all_goods);

        $this->add_data('Customer', $this->build_customer);

        $this->add_data('Address', $this->build_address);

        $params = array
        (
            'newApplicationData' => $this->data_array
        );

        $this->debug($params, 'Soap Params');

        $this->create_client();

        $this->call_result = $this->soap_client->submitNewApplication($params);

        $this->after_call();
    }


    /**
     * Get the Token from the results
     *
     * @access public
     * @return string
     */
    public function get_token()
    {
        $results = $this->results();

        return $results['SubmitNewApplicationResult']->Token;
    }


    /**
     * Get the Proposal ID from the results
     *
     * @access public
     * @return int
     */
    public function get_proposal_id()
    {
        $results = $this->results();

        return $results['SubmitNewApplicationResult']->ProposalID;
    }


}

?>
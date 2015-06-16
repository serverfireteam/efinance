<?php namespace Serverfireteam\Efinance;

/**
 * Barclays eFinance Library - proposalEnquiry
 *
 * @name      bef_proposalEnquiry
 * @author    Ben Griffiths <https://github.com/BenGriffiths/barclays-efinance-api-library>
 */
class bef_proposalEnquiry extends barclaysefinance
{


    /**
     * Check for the fields needed for this call
     *
     * @access public
     * @return void
     */
    public function check_data()
    {
        parent::check_data();

        if(!array_key_exists('ClientReference', $this->data_array))
        {
            throw new exception('<strong>Data missing: ClientReference</strong>');
        }

        if(!array_key_exists('ProposalID', $this->data_array))
        {
            throw new exception('<strong>Data missing: ProposalID</strong>');
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

        $params = array
        (
            'proposalEnquiryData' => $this->data_array
        );

        $this->debug($params, 'Soap Params');

        $this->create_client();

        $this->call_result = $this->soap_client->proposalEnquiry($params);

        $this->after_call();
    }


}

?>
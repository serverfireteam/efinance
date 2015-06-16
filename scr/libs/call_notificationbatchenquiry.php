<?php namespace Serverfireteam\Efinance;

/**
 * Barclays eFinance Library - notificationBatchEnquiry
 *
 * @name      bef_notificationBatchEnquiry
 * @author    Ben Griffiths <https://github.com/BenGriffiths/barclays-efinance-api-library>
 */
class bef_notificationBatchEnquiry extends barclaysefinance
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

        if(!array_key_exists('BatchID', $this->data_array))
        {
            throw new exception('<strong>Data missing: BatchID</strong>');
        }

        if(!array_key_exists('Reference', $this->data_array))
        {
            throw new exception('<strong>Data missing: Reference</strong>');
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
            'notificationBatchEnquiryData' => $this->data_array
        );

        $this->debug($params, 'Soap Params');

        $this->create_client();

        $this->call_result = $this->soap_client->notificationBatchEnquiry($params);

        $this->after_call();
    }


}

?>
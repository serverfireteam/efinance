<?php namespace Serverfireteam\Efinance;

/**
 * Barclays eFinance Library - submitNotificationBatch
 *
 * @name      bef_submitNotificationBatch
 * @author    Ben Griffiths <https://github.com/BenGriffiths/barclays-efinance-api-library>
 */
class bef_submitNotificationBatch extends barclaysefinance
{


    /**
     * Notifications data array
     *
     * @access public
     * @type   array
     */
    public $build_notifications;


    /**
     * Unique Batch Reference String
     *
     * @access public
     * @type   string
     */
    public $build_batch_reference;


    /**
     * Prepare the initial array structures
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
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

        if(empty($this->build_notifications))
        {
            throw new exception('<strong>Data missing: Notifications</strong>');
        }

        if(empty($this->build_batch_reference))
        {
            throw new exception('<strong>Data missing: Batch References</strong>');
        }
    }


    /**
     * Build the Goods data array
     *
     * @access public
     * @return void
     */
    public function build_notifications($proposal_id = '', $agreement_number = '', $client_reference = '', $balance_to_finance = 0)
    {
        $this->build_notifications[] = array
        (
            'ProposalID'       => $proposal_id,
            'AgreementNumber'  => $agreement_number,
            'ClientReference'  => $client_reference,
            'BalanceToFinance' => $balance_to_finance
        );
    }


    /**
     * Build the batch reference string
     *
     * @access public
     * @return void
     */
    public function build_batch_reference($batch_reference = '')
    {
        $this->build_batch_reference = $batch_reference;
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

        $notifications = array();

        foreach($this->build_notifications as $notification)
        {
            $array = array
            (
                'ProposalID'       => $notification['ProposalID'],
                'AgreementNumber'  => $notification['AgreementNumber'],
                'ClientReference'  => $notification['ClientReference'],
                'BalanceToFinance' => $notification['BalanceToFinance']
            );

            $notifications[] = $array;
        }

        $this->add_data('NotificationBatch', array('BatchReference' => $this->build_batch_reference, 'Notification' => $notifications));

        $params = array
        (
            'notificationData' => $this->data_array
        );

        $this->debug($params, 'Soap Params');

        $this->create_client();

        $this->call_result = $this->soap_client->submitNotificationBatch($params);

        $this->after_call();
    }


    /**
     * Get the Batch ID from the results
     *
     * @access public
     * @return int
     */
    public function get_batch_id()
    {
        $results = $this->results();

        return $results['SubmitNotificationBatchResult']->BatchID;
    }


    /**
     * Get the total accepted notifications from the results
     *
     * @access public
     * @return int
     */
    public function get_total_accepted()
    {
        $results = $this->results();

        return $results['SubmitNotificationBatchResult']->NumberOfNotificationsAccepted;
    }


    /**
     * Get the total rejected notifications from the results
     *
     * @access public
     * @return int
     */
    public function get_total_rejected()
    {
        $results = $this->results();

        return $results['SubmitNotificationBatchResult']->NotificationRejections->NumberOfRejections;
    }


    /**
     * Gets a list of the rejected reasons
     *
     * @access public
     * @return int
     */
    public function get_rejection_reasons()
    {
        $results = $this->results();

        $rejection_data = array();

        foreach($results['SubmitNotificationBatchResult']->NotificationRejections->Rejection as $rejection)
        {
            $rejection_data[] = array
            (
                'ProposalID'       => $rejection->ProposalID,
                'AgreementNumber'  => $rejection->AgreementNumber,
                'ClientReference'  => $rejection->ClientReference,
                'Reason'           => $rejection->Reason
            );
        }

        return $rejection_data;
    }


}

?>
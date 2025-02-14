<?php

/**
 * The message type for transaction receipts.
 *
 * This message type is used for generating receipt html (or pdf).  They are either triggered via the thank you page as a link, or the [RECEIPT_URL] shortcode.
 *
 * @package        Event Espresso
 * @subpackage  messages
 * @since            4.5.0
 * @author          Darren Ethier
 */
class EE_Receipt_message_type extends EE_message_type
{

    public function __construct()
    {
        $this->name = 'receipt';
        $this->description = esc_html__('The receipt message type is triggered via a url on the thank you page and via at url generated by the [RECEIPT_URL] shortcode.', 'event_espresso');
        $this->label = array(
            'singular' => esc_html__('receipt', 'event_espresso'),
            'plural' => esc_html__('receipts', 'event_espresso')
        );
        $this->_master_templates = array();
        parent::__construct();
    }



    /**
     * @see parent::get_priority() for documentation.
     * @return int
     */
    public function get_priority()
    {
        return EEM_Message::priority_high;
    }



    /**
     * This method returns whether this message type should always generate a new copy
     * when requested, or if links can be to the already generated copy.
     * Note: this does NOT affect viewing/resending already generated messages in the EE_Message list table.
     * Receipts always generate
     * @return bool     false means can link to generated EE_Message.  true must regenerate.
     */
    public function always_generate()
    {
        return true;
    }


    protected function _set_admin_pages()
    {
        $this->admin_registered_pages = array( 'events_edit' => true );
    }



    protected function _set_data_handler()
    {
        $this->_data_handler = 'Gateways';
    }



    protected function _set_with_messengers()
    {
        $this->_with_messengers = array(
            'html' => array( 'pdf' )
        );
    }



    protected function _get_data_for_context($context, EE_Registration $registration, $id)
    {
        // receipt message type data handler is 'Gateways' and it expects a transaction object.
        $transaction = $registration->transaction();
        if ($transaction instanceof EE_Transaction) {
            return array( $transaction );
        }
        return array();
    }



    protected function _set_admin_settings_fields()
    {
        $this->_admin_settings_fields = array();
    }



    protected function _set_contexts()
    {
        $this->_context_label = array(
            'label' => esc_html__('recipient', 'event_espresso'),
            'plural' => esc_html__('recipients', 'event_espresso'),
            'description' => esc_html__('Recipient\'s are who will view the receipt.', 'event_espresso')
        );

        $this->_contexts = array(
            'purchaser' => array(
                'label' => esc_html__('Purchaser', 'event_espresso'),
                'description' => esc_html__('This template goes to the person who conducted the transaction.', 'event_espresso')
            )
        );
    }




    /**
    * used to set the valid shortcodes for the receipt message type
    *
    * @since   4.5.0
    *
    * @return  void
    */
    protected function _set_valid_shortcodes()
    {
        $this->_valid_shortcodes['purchaser'] = array(
            'attendee_list',
            'attendee',
            'datetime_list',
            'datetime',
            'event_list',
            'event',
            'event_meta',
            'messenger',
            'organization',
            'primary_registration_list',
            'primary_registration_details',
            'ticket_list',
            'ticket',
            'transaction',
            'venue',
            'line_item_list',
            'payment_list',
            'line_item',
            'payment'
        );
    }




    protected function _purchaser_addressees()
    {
        return parent::_primary_attendee_addressees();
    }
}

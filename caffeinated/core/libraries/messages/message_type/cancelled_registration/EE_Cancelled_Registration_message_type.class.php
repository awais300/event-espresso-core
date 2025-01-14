<?php

/**
 *EE_Cancelled_Registration_message_type
 *
 * Handles frontend registration message types.
 *
 * @package     Event Espresso
 * @subpackage  includes/core/messages/message_type/EE_Cancelled_Registration_message_type.class.php
 * @author      Darren Ethier
 *
 * ------------------------------------------------------------------------
 */

class EE_Cancelled_Registration_message_type extends EE_Registration_Base_message_type
{

    public function __construct()
    {
        $this->name = 'cancelled_registration';
        $this->description = esc_html__('This message type is for messages sent to registrants when their registration is cancelled.', 'event_espresso');
        $this->label = array(
            'singular' => esc_html__('registration cancelled', 'event_espresso'),
            'plural' => esc_html__('registrations cancelled', 'event_espresso')
            );
        $this->_master_templates = array(
            'email' => 'not_approved_registration'
            );
        parent::__construct();
    }




    /**
     * _set_contexts
     * This sets up the contexts associated with the message_type
     *
     * @access  protected
     * @return  void
     */
    protected function _set_contexts()
    {
        $this->_context_label = array(
            'label' => esc_html__('recipient', 'event_espresso'),
            'plural' => esc_html__('recipients', 'event_espresso'),
            'description' => esc_html__('Recipient\'s are who will receive the template.  You may want different registration details sent out depending on who the recipient is', 'event_espresso')
            );

        $this->_contexts = array(
            'admin' => array(
                'label' => esc_html__('Event Admin', 'event_espresso'),
                'description' => esc_html__('This template is what event administrators will receive with an cancelled registration', 'event_espresso')
                ),
            'attendee' => array(
                'label' => esc_html__('Registrant', 'event_espresso'),
                'description' => esc_html__('This template is what each registrant for the event will receive when their registration is cancelled.', 'event_espresso')
                )
            );
    }



    protected function _set_valid_shortcodes()
    {
        parent::_set_valid_shortcodes();

        // remove unwanted transaction shortcode
        foreach ($this->_valid_shortcodes as $context => $shortcodes) {
            if (($key = array_search('transaction', $shortcodes) ) !== false) {
                unset($this->_valid_shortcodes[ $context ][ $key ]);
            }
        }
    }
}

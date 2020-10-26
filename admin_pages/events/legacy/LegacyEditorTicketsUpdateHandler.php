<?php

namespace EventEspresso\admin_pages\events\legacy;

use DateTime;
use DateTimeZone;
use EE_Admin_Config;
use EE_Datetime;
use EE_Error;
use EE_Event;
use EE_Registry;
use EE_Ticket;
use EEH_DTT_Helper;
use EEH_Money;
use EEM_Datetime;
use EEM_Registration;
use EEM_Ticket;
use EventEspresso\core\exceptions\InvalidDataTypeException;
use EventEspresso\core\exceptions\InvalidEntityException;
use EventEspresso\core\exceptions\InvalidInterfaceException;
use Exception;
use InvalidArgumentException;
use ReflectionException;

/**
 * Class LegacyEditorTicketsUpdateHandler
 *
 * @package EventEspresso\admin_pages\events\legacy
 * @since   $VID:$
 */
class LegacyEditorTicketsUpdateHandler
{

    private $date_format = 'Y-m-d';
    private $time_format = 'h:i a';
    private $date_time_format = 'Y-m-d h:i a';

    /**
     * @var EE_Admin_Config
     */
    private $admin_config;

    /**
     * @var EEM_Datetime $datetime_model
     */
    private $datetime_model;

    /**
     * @var EEM_Ticket $ticket_model
     */
    private $ticket_model;


    /**
     * @param EE_Event $event
     * @param array    $data
     * @return array
     * @throws EE_Error
     * @throws ReflectionException
     * @throws Exception
     */
    public function update(EE_Event $event, array $data)
    {
        if ($this->admin_config->useAdvancedEditor()) {
            return [];
        }
        $event_timezone = $event->get_timezone();
        $first_datetime = $event->first_datetime();
        $this->datetime_model->set_timezone($event_timezone);
        $now = new DateTime('now', new DateTimeZone($event_timezone));
        $datetime = $this->getDatetimeFromData($event, $data);
        $saved_tickets = [];
        // update tickets next
        foreach ($data['edit_tickets'] as $row => $tkt) {
            $update_prices = false;
            $ticket_price = isset($data['edit_prices'][ $row ][1]['PRC_amount'])
                ? $data['edit_prices'][ $row ][1]['PRC_amount']
                : 0;
            // trim inputs to ensure any excess whitespace is removed.
            $TKT_values = array_map('trim', $tkt);
            if (empty($TKT_values['TKT_start_date'])) {
                // let's use now in the set timezone.
                $TKT_values['TKT_start_date'] = $now->format($this->date_time_format);
            }
            if (empty($TKT_values['TKT_end_date'])) {
                // use the start date of the first datetime
                $TKT_values['TKT_end_date'] = $first_datetime->start_date_and_time($this->date_format, $this->time_format);
            }
            $TKT_values = [
                'TKT_ID'          => ! empty($tkt['TKT_ID']) ? $tkt['TKT_ID'] : null,
                'TTM_ID'          => ! empty($tkt['TTM_ID']) ? $tkt['TTM_ID'] : 0,
                'TKT_name'        => ! empty($tkt['TKT_name']) ? $tkt['TKT_name'] : '',
                'TKT_description' => ! empty($tkt['TKT_description']) ? $tkt['TKT_description'] : '',
                'TKT_start_date'  => $tkt['TKT_start_date'],
                'TKT_end_date'    => $tkt['TKT_end_date'],
                'TKT_qty'         => ! isset($tkt['TKT_qty']) || $tkt['TKT_qty'] === '' ? EE_INF : $tkt['TKT_qty'],
                'TKT_uses'        => ! isset($tkt['TKT_uses']) || $tkt['TKT_uses'] === '' ? EE_INF : $tkt['TKT_uses'],
                'TKT_min'         => empty($tkt['TKT_min']) ? 0 : $tkt['TKT_min'],
                'TKT_max'         => empty($tkt['TKT_max']) ? EE_INF : $tkt['TKT_max'],
                'TKT_row'         => $row,
                'TKT_order'       => isset($tkt['TKT_order']) ? $tkt['TKT_order'] : $row,
                'TKT_price'       => $ticket_price,
            ];
            // if this is a default TKT, then we need to set the TKT_ID to 0 and update accordingly,
            // which means in turn that the prices will become new prices as well.
            if (isset($tkt['TKT_is_default']) && $tkt['TKT_is_default']) {
                $TKT_values['TKT_ID']         = 0;
                $TKT_values['TKT_is_default'] = 0;
                $TKT_values['TKT_price']      = $ticket_price;
                $update_prices                = true;
            }
            // if we have a TKT_ID then we need to get that existing TKT_obj and update it
            // we actually do our saves a head of doing any add_relations to
            // because its entirely possible that this ticket wasn't removed or added to any datetime in the session
            // but DID have it's items modified.
            // keep in mind that if the TKT has been sold (and we have changed pricing information),
            // then we won't be updating the tkt but instead a new tkt will be created and the old one archived.
            if (! empty($tkt['TKT_ID'])) {
                $TKT = EE_Registry::instance()
                                  ->load_model('Ticket', [$event_timezone])
                                  ->get_one_by_ID($tkt['TKT_ID']);
                if ($TKT instanceof EE_Ticket) {
                    $ticket_sold = $TKT->count_related(
                            'Registration',
                            [
                                [
                                    'STS_ID' => [
                                        'NOT IN',
                                        [EEM_Registration::status_id_incomplete],
                                    ],
                                ],
                            ]
                        ) > 0;
                    // let's just check the total price for the existing ticket and determine if it matches the new
                    // total price.  if they are different then we create a new ticket (if tickets sold)
                    // if they aren't different then we go ahead and modify existing ticket.
                    $create_new_TKT = $ticket_sold && ! $TKT->deleted()
                                      && EEH_Money::compare_floats(
                            $ticket_price,
                            $TKT->get('TKT_price'),
                            '!=='
                        );
                    $TKT->set_date_format($this->date_format);
                    $TKT->set_time_format($this->time_format);
                    // set new values
                    foreach ($TKT_values as $field => $value) {
                        if ($field === 'TKT_qty') {
                            $TKT->set_qty($value);
                        } else {
                            $TKT->set($field, $value);
                        }
                    }
                    // if $create_new_TKT is false then we can safely update the existing ticket.
                    // Otherwise we have to create a new ticket.
                    if ($create_new_TKT) {
                        // archive the old ticket first
                        $TKT->set('TKT_deleted', 1);
                        $TKT->save();
                        // make sure this ticket is still recorded in our saved_tkts
                        // so we don't run it through the regular trash routine.
                        $saved_tickets[ $TKT->ID() ] = $TKT;
                        // create new ticket that's a copy of the existing except a new id of course
                        // (and not archived) AND has the new TKT_price associated with it.
                        $TKT = clone $TKT;
                        $TKT->set('TKT_ID', 0);
                        $TKT->set('TKT_deleted', 0);
                        $TKT->set('TKT_price', $ticket_price);
                        $TKT->set('TKT_sold', 0);
                        // now we need to make sure that $new prices are created as well and attached to new ticket.
                        $update_prices = true;
                    }
                    // make sure price is set if it hasn't been already
                    $TKT->set('TKT_price', $ticket_price);
                }
            } else {
                // no TKT_id so a new TKT
                $TKT_values['TKT_price'] = $ticket_price;
                $TKT = EE_Registry::instance()->load_class('Ticket', [$TKT_values], false, false);
                if ($TKT instanceof EE_Ticket) {
                    // need to reset values to properly account for the date formats
                    $TKT->set_date_format($this->date_format);
                    $TKT->set_time_format($this->time_format);
                    $TKT->set_timezone($event_timezone);
                    // set new values
                    foreach ($TKT_values as $field => $value) {
                        if ($field === 'TKT_qty') {
                            $TKT->set_qty($value);
                        } else {
                            $TKT->set($field, $value);
                        }
                    }
                    $update_prices = true;
                }
            }
            // cap ticket qty by datetime reg limits
            $TKT->set_qty(min($TKT->qty(), $TKT->qty('reg_limit')));
            // update ticket.
            $TKT->save();
            // before going any further make sure our dates are setup correctly
            // so that the end date is always equal or greater than the start date.
            if ($TKT->get_raw('TKT_start_date') > $TKT->get_raw('TKT_end_date')) {
                $TKT->set('TKT_end_date', $TKT->get('TKT_start_date'));
                $TKT = EEH_DTT_Helper::date_time_add($TKT, 'TKT_end_date', 'days');
                $TKT->save();
            }
            // initially let's add the ticket to the dtt
            $datetime->_add_relation_to($TKT, 'Ticket');
            $saved_tickets[ $TKT->ID() ] = $TKT;
            // add prices to ticket
            $this->addPricesToTicket($data['edit_prices'][ $row ], $TKT, $update_prices);
        }
        $old_tickets = isset($data['ticket_IDs']) ? explode(',', $data['ticket_IDs']) : [];
        $this->removeTickets($old_tickets, $saved_tickets);
        return [$datetime, $saved_tickets];
    }


    /**
     * @param EE_Event $event
     * @param array    $data
     * @return EE_Datetime
     * @throws EE_Error
     * @throws ReflectionException
     */
    private function getDatetimeFromData(EE_Event $event, array $data)
    {
        $datetime = null;
        $event_timezone = $event->get_timezone();
        foreach ($data['edit_event_datetimes'] as $row => $dtt) {
            $datetime_data = $this->prepDatetimeData($data, $row);
            // if we have an id then let's get existing object first.
            // Otherwise we instantiate a new object for save.
            $DTT_ID = ! empty($datetime_data['DTT_ID']) ? absint($datetime_data['DTT_ID']) : 0;
            $datetime = $DTT_ID > 0
                ? EE_Datetime::new_instance_from_db($datetime_data, $event_timezone)
                : EE_Datetime::new_instance($datetime_data, $event_timezone);
            // golden rule of programming
            if (! $datetime instanceof EE_Datetime) {
                throw new InvalidEntityException($datetime, 'EE_Datetime');
            }
            $datetime->set_date_format($this->date_format);
            $datetime->set_time_format($this->time_format);
            // before going any further make sure our dates are setup correctly
            // so that the end date is always equal or greater than the start date.
            if ($datetime->get_raw('DTT_EVT_start') > $datetime->get_raw('DTT_EVT_end')) {
                $datetime->set('DTT_EVT_end', $datetime->get('DTT_EVT_start'));
                EEH_DTT_Helper::date_time_add($datetime, 'DTT_EVT_end', 'days');
            }
            $datetime->save();
            $event->_add_relation_to($datetime, 'Datetime');
        }
        return $datetime;
    }


    /**
     * @param array $data
     * @param int   $row
     * @return array
     */
    private function prepDatetimeData(array $data, int $row)
    {
        // trim all values to ensure any excess whitespace is removed.
        $datetime_data = array_map('trim', $data);
        // ensure critical values are set
        $datetime_data['DTT_EVT_end'] = ! empty($datetime_data['DTT_EVT_end'])
            ? $datetime_data['DTT_EVT_end']
            : $datetime_data['DTT_EVT_start'];
        $datetime_data['DTT_reg_limit'] = ! empty($datetime_data['DTT_reg_limit'])
            ? $datetime_data['DTT_reg_limit']
            : EE_INF;
        $datetime_data ['DTT_order'] = $row;
        return $datetime_data;
    }


    /**
     * This attaches a list of given prices to a ticket.
     * Note we dont' have to worry about ever removing relationships (or archiving prices) because if there is a change
     * in price information on a ticket, a new ticket is created anyways so the archived ticket will retain the old
     * price info and prices are automatically "archived" via the ticket.
     *
     * @param array     $prices     Array of prices from the form.
     * @param EE_Ticket $ticket     EE_Ticket object that prices are being attached to.
     * @param bool      $new_prices Whether attach existing incoming prices or create new ones.
     * @return  void
     * @throws EE_Error
     * @throws InvalidArgumentException
     * @throws InvalidDataTypeException
     * @throws InvalidInterfaceException
     * @throws ReflectionException
     */
    private function addPricesToTicket(array $prices, EE_Ticket $ticket, $new_prices = false)
    {
        foreach ($prices as $row => $prc) {
            $PRC_values = [
                'PRC_ID'         => ! empty($prc['PRC_ID']) ? $prc['PRC_ID'] : null,
                'PRT_ID'         => ! empty($prc['PRT_ID']) ? $prc['PRT_ID'] : null,
                'PRC_amount'     => ! empty($prc['PRC_amount']) ? $prc['PRC_amount'] : 0,
                'PRC_name'       => ! empty($prc['PRC_name']) ? $prc['PRC_name'] : '',
                'PRC_desc'       => ! empty($prc['PRC_desc']) ? $prc['PRC_desc'] : '',
                'PRC_is_default' => 0, // make sure prices are NOT set as default from this context
                'PRC_order'      => $row,
            ];
            if ($new_prices || empty($PRC_values['PRC_ID'])) {
                $PRC_values['PRC_ID'] = 0;
                $PRC = EE_Registry::instance()->load_class('Price', [$PRC_values], false, false);
            } else {
                $PRC = EE_Registry::instance()->load_model('Price')->get_one_by_ID($prc['PRC_ID']);
                // update this price with new values
                foreach ($PRC_values as $field => $new_price) {
                    $PRC->set($field, $new_price);
                }
                $PRC->save();
            }
            $ticket->_add_relation_to($PRC, 'Price');
        }
    }


    /**
     * handles permanently deleting tickets
     * Keep in mind that the ui does not allow deleting/archiving tickets that have ticket sold.
     * However, it does allow for deleting tickets that have no tickets sold,
     * in which case we want to get rid of them permanently because there is no need to save in db.
     *
     * @param array $old_tickets
     * @param array $saved_tickets
     * @throws EE_Error
     * @throws ReflectionException
     */
    private function removeTickets(array $old_tickets, array $saved_tickets)
    {
        $old_tickets = isset($old_tickets[0]) && $old_tickets[0] === '' ? [] : $old_tickets;
        $tickets_removed = array_diff($old_tickets, array_keys($saved_tickets));
        foreach ($tickets_removed as $id) {
            $id = absint($id);
            // get the ticket for this id
            $ticket_to_remove = $this->ticket_model->get_one_by_ID($id);
            // need to get all the related datetimes on this ticket and remove from every single one of them
            // (remember this process can ONLY kick off if there are NO tickets sold)
            $datetimes = $ticket_to_remove->get_many_related('Datetime');
            foreach ($datetimes as $datetime) {
                $ticket_to_remove->_remove_relation_to($datetime, 'Datetime');
            }
            // need to do the same for prices (except these prices can also be deleted because again,
            // tickets can only be trashed if they don't have any TKTs sold (otherwise they are just archived))
            $ticket_to_remove->delete_related_permanently('Price');
            // finally let's delete this ticket
            // (which should not be blocked at this point b/c we've removed all our relationships)
            $ticket_to_remove->delete_permanently();
        }
    }
}
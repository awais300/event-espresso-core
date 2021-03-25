<?php

/**
 * EE_Restriction_Generator_Base
 * Create an array of restrictions (@see EEM_Base::_cap_restrictions)
 * based off the model and the capabilities defined in EE_Capabilities.
 * .
 * The primary method on this class is _generate_restrictions(), which returns
 * an array where keys are capability names (eg "ee_read_others_events")
 * and values are EE_Default_Where_Conditions objects.
 * Please Note:
 *      EE_Default_Where_Conditions can be passed in an array of model query
 *      param WHERE conditions, and you can retrieve those using
 *      EE_Default_Where_Conditions::get_default_where_conditions().
 * We use these classes instead of the array directly because
 * in some cases the classes themselves can be interpreted in a special way
 * for example:
 *      EE_Return_None_Where_Conditions,
 *      which alters the query parameters in a special way
 *      so NO results get returned, which some client code can use
 *      to decide to not bother running a query at all
 *      if that class is in the list of applicable restrictions
 * sometimes we need to generate the WHERE conditions at the time of querying
 * for example:
 *      because the $current_user global isn't set when models are constructed,
 *      but is when they are queried
 * and because this class simplifies adding default where conditions onto a
 * query from a related model object for example: while querying events, you
 * may include datetimes in the query, in which case we may someday decide to
 * add the capabilities restrictions for the datetime onto the query too, not
 * just those for events
 *
 * @package     Event Espresso
 * @subpackage
 * @author      Mike Nelson
 */
abstract class EE_Restriction_Generator_Base
{

    /**
     * One of EEM_Base::valid_cap_contexts()
     *
     * @var string
     */
    protected $_action;

    /**
     * The restrictions generated by this object. FALSE before any are made.
     *
     * @var EE_Default_Where_Conditions[]
     */
    protected $_cap_restrictions_generated;

    /**
     * Model for which restrictions are generated
     *
     * @var EEM_Base
     */
    protected $_model;


    /**
     * Puts the last necessary info onto the restriction generator class. This
     * is usually called by EEM_Base during its constructor, so child classes
     * don't have to always provide this info.
     *
     * @param EEM_Base $model
     * @param string   $action
     */
    public function _construct_finalize(EEM_Base $model, string $action)
    {
        $this->_model  = $model;
        $this->_action = $action;
    }


    /**
     * Returns the model set for this restriction generator
     *
     * @return EEM_Base|EEM_Soft_Delete_Base
     * @throws EE_Error
     */
    public function model()
    {
        if (! $this->_model instanceof EEM_Base) {
            throw new EE_Error(
                sprintf(
                    esc_html__(
                        'Cannot generate capability restrictions because model has not yet been set on the %s. Please ensure _construct_finalize() was called',
                        'event_espresso'
                    ),
                    get_class($this)
                )
            );
        }
        return $this->_model;
    }


    /**
     * Returns the action this restriction generator will generate restrictions
     * for. It should be one of EEM_Base::valid_cap_contexts()
     *
     * @return string
     * @throws EE_Error
     */
    public function action(): string
    {
        if (! $this->_action) {
            throw new EE_Error(
                sprintf(
                    esc_html__(
                        'Cannot generate capability restrictions because model has not yet been set on the %s. Please ensure _construct_finalize() was called',
                        'event_espresso'
                    ),
                    get_class($this)
                )
            );
        }
        return $this->_action;
    }


    /**
     * Returns whether or not _construct_finalize() has been called on this
     * restriction generator object
     *
     * @return boolean
     */
    public function construction_finalized(): bool
    {
        return $this->_model instanceof EEM_Base && $this->_action;
    }


    /**
     * Gets the capability restrictions generated by this object. Caches them in
     * case they are required for subsequent requests
     *
     * @return array @see EEM_Base::_cap_restrictions
     */
    public function generate_restrictions(): array
    {
        if ($this->_cap_restrictions_generated === null) {
            $this->_cap_restrictions_generated = apply_filters(
                'FHEE__EE_Restriction_Generator_Base__generate_restrictions__first_time',
                $this->_generate_restrictions(),
                $this
            );
        }
        return apply_filters(
            'FHEE__EE_Restriction_Generator_Base__generate_restrictions__every_time',
            $this->_cap_restrictions_generated,
            $this
        );
    }


    /**
     * Provided with the model, and using global knowledge about what
     * capabilities exist, generates an array for use in one of the sub-arrays
     * in EEM_Base::_cap_restrictions, where keys are capability names, and
     * values are children of EE_Default_Where_Conditions
     *
     * @return EE_Default_Where_Conditions[]|EE_Return_None_Where_Conditions[]
     * @see EEM_Base::_cap_restrictions
     */
    abstract protected function _generate_restrictions(): array;


    /**
     * Whether or not this restriction generator has already done its job of
     * making restrictions and caching them on itself in case its asked later
     *
     * @return boolean
     */
    public function has_generated_cap_restrictions(): bool
    {
        return $this->_cap_restrictions_generated !== null;
    }


    /**
     * Given an action like 'edit' generates the cap name based off
     * the EEM_Base::_cap_slug, which for events would be 'events', to generate
     * the cap name like 'ee_edit_events'. If a $qualifier is passed,
     *
     * @param EEM_Base $model
     * @param string   $action
     * @return string
     */
    public static function get_cap_name(EEM_Base $model, string $action): string
    {
        $prefix = $model->is_wp_core_model() ? '' : 'ee_';
        $cap_slug = $model->cap_slug();
        return apply_filters(
            'FHEE__EE_Restriction_Generator__get_cap_name',
            "{$prefix}{$action}_{$cap_slug}",
            $model,
            $action
        );
    }


    /**
     * Checks if there is a cap for this model and this action
     *
     * @param EEM_Base $model
     * @param string   $action
     * @return boolean
     * @throws EE_Error
     */
    public static function is_cap(EEM_Base $model, string $action): bool
    {
        $caps_for_admin = EE_Registry::instance()->CAP->get_ee_capabilities();
        return in_array(self::get_cap_name($model, $action), $caps_for_admin);
    }


    /**
     * Returns the default capability used to determine if the current user can
     * access something.
     *
     * @return string
     */
    public static function get_default_restrictions_cap(): string
    {
        return apply_filters(
            'FHEE__EE_Restriction_Generator_Base__default_restrictions_cap',
            'manage_options'
        );
    }


    /**
     * Gets WHERE conditions for the query that show the post model is
     * published, or that it's sold out and it was previously published
     *
     * @param array   $where_conditions
     * @param boolean $check_if_published  if true, will add conditions like
     *                                     status=publish if false, will add
     *                                     conditions like status!=private
     * @param string  $path_to_event_model including the period at the end
     * @return array
     * @throws EE_Error
     */
    protected function addPublishedPostConditions(
        $where_conditions = [],
        $check_if_published = true,
        $path_to_event_model = ''
    ): array {
        if ($check_if_published) {
            $published_value = 'publish';
        } else {
            $published_value = ['!=', 'private'];
        }
        // only add a check for the previous event status
        // if the model is the event or it's related to the event model
        if (
            $this->model() instanceof EEM_Event
            || strpos($path_to_event_model, 'Event') !== false
        ) {
            $where_conditions['OR*status'] = [
                $path_to_event_model . 'status' => $published_value,
                'AND'                           => [
                    $path_to_event_model .
                    'Post_Meta.meta_key'                          => '_previous_event_status',
                    $path_to_event_model .
                    'Post_Meta.meta_value'                        => $published_value,
                ],
            ];
        } else {
            $where_conditions[ $path_to_event_model . 'status' ] =
                $published_value;
        }
        return $where_conditions;
    }
}

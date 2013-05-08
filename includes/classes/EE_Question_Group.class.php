<?php if ( ! defined('EVENT_ESPRESSO_VERSION')) exit('No direct script access allowed');
/**
 * Event Espresso 
 *
 * Event Registration and Management Plugin for WordPress
 *
 * @ package			Event Espresso
 * @ author				Seth Shoultes
 * @ copyright		(c) 2008-2011 Event Espresso  All Rights Reserved.
 * @ license			{@link http://eventespresso.com/support/terms-conditions/}   * see Plugin Licensing *
 * @ link					{@link http://www.eventespresso.com}
 * @ since		 		4.0
 *
 * ------------------------------------------------------------------------
 *
 * EE_Answer class
 *
 * @package			Event Espresso
 * @subpackage		includes/classes/EE_Answer.class.php
 * @author				Mike Nelson
 *
 * ------------------------------------------------------------------------
 */
require_once ( 'EE_Soft_Delete_Base_Class.class.php' );
class EE_Question_Group extends EE_Soft_Delete_Base_Class{
	
	/**
	 * ID of this question gruop
	 * @access protected
	 * @var int
	 */
	protected $_QSG_ID=FALSE;
	
	/**
	 * Name of this question group. eg, 'addrss info'
	 * @access protected
	 * @var stirng
	 */
	protected $_QSG_name=NULL;
	
	/**
	 * The unique identifier used for this question group within the system
	 * @access protected
	 * @var string
	 */
	protected $_QSG_identifier=NULL;
	
	/**
	 * Question group descripton
	 * @access protected
	 * @var string
	 */
	protected $_QSG_desc=NULL;
	
	/**
	 * Integer to indicate where this question group
	 * should be placed relative to other question gruops in a sequence
	 * @access protected 
	 * @var int
	 */
	protected $_QSG_order=NULL;
	
	/**
	 * Boolean to indicate whether the group name
	 * should be shown when displaying this question group
	 * on the frontend
	 * @access protected
	 * @var boolean 
	 */
	protected $_QSG_show_group_name=NULL;
	
	/**
	 * Boolean to dinicate whether the group description
	 * should be shown when displayign this question gruop
	 * on the frontend
	 * @access protected
	 * @var boolean 
	 */
	protected $_QSG_show_group_desc=NULL;
	
	/**
	 * Boolean to indicate whether this question gruop
	 * is a mandatory one, ie integral to the system
	 * @access protected
	 * @var boolean 
	 */
	protected $_QSG_system_ID=NULL;
	
	/**
	 * Boolean which indicates whether thsi question group
	 * has been deleted or not
	 * @access protected
	 * @var boolean 
	 */
	protected $_QSG_deleted=NULL;
	
	
	/**
	 * Related questions, lazy-loaded.
	 * @access protected
	 * @var EE_Question 
	 */
	protected $_Question;
	
	/**
	 * Related Events
	 * @access protected
	 * @var EE_Event
	 */
	protected $_Event;
	
	/**
	 * Join model object between events and question groups. Mostly just useful for finding
	 * which question gruops apply to primary attendees
	 * @access protected
	 * @var EE_Event_Question_Group
	 */
	protected $_Event_Question_Group;
	


	/**
	 * Constructor
	 *
	 * @access protected
	 * @param array array of values indexed by property name (without the leading underscore)
	 * @param bool  $bydb indicates whether the model is instantiating this class or not
	 * @return void
	 */
	protected function __construct( $fieldValues = array(), $bydb = FALSE ) {
		parent::__construct($fieldValues, $bydb);
	}
	
	

	public static function new_instance( $props_n_values = array() ) {
		$classname = get_class( self );
		$has_object = parent::_check_for_object( $props_n_values, $classname );
		return $has_object ? $has_object : self::__construct( $props_n_values );
	}




	public static function new_instance_from_db ( $props_n_values = array() ) {
		self::__construct( $props_n_values, TRUE );
	}
	
	
	
	
	/**
	 * gets teh question gruop's name
	 * @access public
	 * @return string
	 */
	public function name(){
		return $this->get('QSG_name');
	}
	
	/**
	 * Gets the question group's internal name
	 * @access public
	 * @return string
	 */
	public function identifier(){
		return $this->get('QSG_identifier');
	}
	
	/**
	 * Gets the question group's description
	 * @access public
	 * @return string
	 */
	public function desc(){
		return $this->get('QSG_desc');
	}
	
	/**
	 * Gets the question group's order number in a sequence
	 * of other quesiton groups
	 * @access public
	 * @return int
	 */
	public function order(){
		return $this->get('QSG_order');
	}
	
	/**
	 * Returns whether to show the gruop's name on teh frontend
	 * @access public
	 * @return boolean
	 */
	public function show_group_name(){
		return $this->get('QSG_show_group_name');
	}
	
	/**
	 * Returns wehther to show the group's descripton
	 * on the frontend
	 * @access public
	 * @return boolean
	 */
	public function show_group_desc(){
		return $this->get('QSG_show_group_desc');
	}
	
	/**
	 * Returns wehther this is a 'sytem group' (meaning
	 * a question gruop integral to teh system, whose questions
	 * relate to teh attendee table)
	 * @access public
	 * @return boolean
	 */
	public function system_group(){
		return $this->get('QSG_system_ID');
	}
	
	/**
	 * Returns whether this question gruop has
	 * been deleted
	 * @access public
	 * @return boolean
	 */
	public function deleted(){
		return $this->get('QST_deleted');
	}
	
	/**
	 * Gets all the questions whicha re part of this question gruop
	 * @return EE_Question[]
	 */
	public function questions(){
		return $this->get_many_related('Question');
		}
	
	/**
	 * Gets all events which 
	 * @return EE_Event[]
	 */
	public function events(){
		throw new EE_Error(__("Question Group->events() not yet implemetned","event_esresso"));
		return $this->get_many_related('Event');
	}
	
	/**
	 * Adds the question to this question group
	 * @param EE_Question || int $question object or ID
	 * @return boolean if successful
	 */
	public function add_question($questionObjectOrID){
		return $this->_add_relation_to($questionObjectOrID, 'Question');
	}
	/**
	 * Removes the question from this question group
	 * @param EE_Question || int $question object or ID
	 * @return boolean of success
	 */
	public function remove_question($questionObjectOrID){
		return $this->_remove_relation_to($questionObjectOrID, 'Question');
	}
}

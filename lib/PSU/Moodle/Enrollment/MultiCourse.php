<?php

namespace PSU\Moodle\Enrollment; 

use Enrollment\Exception;

class MultiCourse extends \PSU\Moodle\Enrollment {

	/**
	 * _construct
	 *
	 * magic constructor method
	 *
	 * @param    $url    Optional url parameted to post generated xml to.
	 */
	public function __construct( $course, $population, $role = 'student', $args = '' ){
		if( !is_array( $course ) ) {
			throw new Exception( 'Courses must be in an array of Moodle course ids!: '.$course );
		}//end if

		parent::__construct( $course, $population, $role, $args );

	}//end __construct

	public function enroll() {
		foreach( $this->course as $id ) {
			self::add_to_flatfile( $this->population, $id );
		}//end foreach

		self::write_to_flatfile();
	}//end manual

}//end PSU_Moodle_Enrollment	

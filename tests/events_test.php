<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Events tests.
 *
 * @package    assignsubmission_assessmentflags
 * @category   test
 * @copyright  2013 Rajesh Taneja <rajesh@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/mod/assign/lib.php');
require_once($CFG->dirroot . '/mod/assign/locallib.php');
require_once($CFG->dirroot . '/mod/assign/tests/base_test.php');

/**
 * Events tests class.
 *
 * @package    assignsubmission_assessmentflags
 * @category   test
 * @copyright  2013 Rajesh Taneja <rajesh@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class assignsubmission_assessmentflags_events_testcase extends mod_assign_base_testcase {

    /**
     * Test gradereview_created event.
     */
    public function test_gradereview_created() {
        global $CFG;
        require_once($CFG->dirroot . '/comment/lib.php');

        $this->setUser($this->editingteachers[0]);
        $assign = $this->create_instance();
        $submission = $assign->get_user_submission($this->students[0]->id, true);

        $context = $assign->get_context();
        $options = new stdClass();
        $options->area = 'submission_assessmentflags';
        $options->course = $assign->get_course();
        $options->context = $context;
        $options->itemid = $submission->id;
        $options->component = 'assignsubmission_assessmentflags';
        $options->showcount = true;
        $options->displaycancel = true;

        $gradereview = new comment($options);

        // Triggering and capturing the event.
        $sink = $this->redirectEvents();
        $gradereview->add('New gradereview');
        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = reset($events);

        // Checking that the event contains the expected values.
        $this->assertInstanceOf('\assignsubmission_assessmentflags\event\gradereview_created', $event);
        $this->assertEquals($context, $event->get_context());
        $url = new moodle_url('/mod/assign/view.php', array('id' => $assign->get_course_module()->id));
        $this->assertEquals($url, $event->get_url());
        $this->assertEventContextNotUsed($event);
    }

    /**
     * Test gradereview_deleted event.
     */
    public function test_gradereview_deleted() {
        global $CFG;
        require_once($CFG->dirroot . '/comment/lib.php');

        $this->setUser($this->editingteachers[0]);
        $assign = $this->create_instance();
        $submission = $assign->get_user_submission($this->students[0]->id, true);

        $context = $assign->get_context();
        $options = new stdClass();
        $options->area    = 'submission_assessmentflags';
        $options->course    = $assign->get_course();
        $options->context = $context;
        $options->itemid  = $submission->id;
        $options->component = 'assignsubmission_assessmentflags';
        $options->showcount = true;
        $options->displaycancel = true;
        $gradereview = new comment($options);
        $newgradereview = $gradereview->add('New gradereview 1');

        // Triggering and capturing the event.
        $sink = $this->redirectEvents();
        $gradereview->delete($newgradereview->id);
        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = reset($events);

        // Checking that the event contains the expected values.
        $this->assertInstanceOf('\assignsubmission_assessmentflags\event\gradereview_deleted', $event);
        $this->assertEquals($context, $event->get_context());
        $url = new moodle_url('/mod/assign/view.php', array('id' => $assign->get_course_module()->id));
        $this->assertEquals($url, $event->get_url());
        $this->assertEventContextNotUsed($event);
    }
}

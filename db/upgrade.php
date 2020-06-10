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
 * Upgrade code for install
 *
 * @package   assignsubmission_assessmentflags
 * @copyright 2012 NetSpot {@link http://www.netspot.com.au}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Stub for upgrade code
 * @param int $oldversion
 * @return bool
 */
function xmldb_assignsubmission_assessmentflags_upgrade($oldversion) {
    global $DB;

    // Moodle v2.3.0 release upgrade line.
    // Put any upgrade step following this.

    // Moodle v2.4.0 release upgrade line.
    // Put any upgrade step following this.

    // Moodle v2.5.0 release upgrade line.
    // Put any upgrade step following this.

    // Moodle v2.6.0 release upgrade line.
    // Put any upgrade step following this.

    // Moodle v2.7.0 release upgrade line.
    // Put any upgrade step following this.

    // Moodle v2.8.0 release upgrade line.
    // Put any upgrade step following this.

    // Moodle v2.9.0 release upgrade line.
    // Put any upgrade step following this.

    $dbman = $DB->get_manager();

    if ($oldversion < 2016042206) {

        // Update all capability to new one.
        $oldcap = $DB->get_record('capabilities', array('name' => 'moodle/site:canaddflags'));
        $oldcap->name = 'assign/submission:canaddflags';
        $oldcap->component = 'assignsubmission_assessmentflags';
        $DB->update_record('capabilities', $oldcap);

        $oldcap = $DB->get_record('capabilities', array('name' => 'moodle/site:caneditassessmentflags'));
        $oldcap->name = 'assign/submission:caneditassessmentflags';
        $oldcap->component = 'assignsubmission_assessmentflags';
        $DB->update_record('capabilities', $oldcap);


        // Assign submission savepoint reached.
        upgrade_plugin_savepoint(true, 2016042206, 'assignsubmission', 'assessmentflags');
    }

    if ($oldversion < 2016042207) {

        // Update all role_capability to new one.
        $oldcaps = $DB->get_records('role_capabilities', array('capability' => 'moodle/site:canaddflags'));
        if (!empty($oldcaps)) {
            foreach ($oldcaps as $oldcap) {
                $oldcap->capability = 'assign/submission:canaddflags';
                $DB->update_record('role_capabilities', $oldcap);
            }
        }

        $oldeditcaps = $DB->get_records('role_capabilities', array('capability' => 'moodle/site:caneditassessmentflags'));
        if (!empty($oldeditcaps)) {
            foreach ($oldeditcaps as $oldcap) {
                $oldcap->capability = 'assign/submission:caneditassessmentflags';
                $DB->update_record('role_capabilities', $oldcap);
            }
        }

        // Assign submission savepoint reached.
        upgrade_plugin_savepoint(true, 2016042207, 'assignsubmission', 'assessmentflags');
    }

    return true;
}



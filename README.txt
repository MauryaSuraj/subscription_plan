local plugin: eledia_coursewizard
=================================


Overview
--------
This block is a wizard. With this block a user with specific rights can easily create new courses and enrol
users into the new course just by adding their e-mail addresses.
For e-mail adresses which ar not known in your moodle system,
a new user will be created and automatically enroled into the new course.
New users will get an e-mail with login data.

You can even add users to an existing course.

For this block there is no need to have the moodle rights to create courses or users.
This block brings along three new rights:

- block/eledia_coursewizard:create_course:
    User can create a course with the course wizard block.

- block/eledia_coursewizard:create_user:
    User can add and create users with the course wizard block.

- block/eledia_coursewizard:change_category:
    User can change the category for new course created with the course wizard block.
    Without this right the new course will be created in the category of the origin course.

Users who already have the rights to create courses or users or to edit course categories do not need
the corresponding right for the course wizard block.


Requirements
------------
Moodle 2.6


Installation
------------
The zip-archive includes the same directory hierarchy as moodle.
So you only have to copy the files to the correspondent place.
Copy the folder eledia_coursewizard to moodle/local/paradiso_coursewizard.
The langfiles normaly can be left into the folder moodle/local/paradiso_coursewizard/lang.
All languages should be encoded with utf8.

After it you have to run the admin-page of moodle (http://your-moodle-site/admin)
in your browser. You have to loged in as admin before.
The installation process will be displayed on the screen.
That's all.


Administration
--------------
You can setup the plugin by going to
Site administration --> Plugins --> Blocks --> Course wizard.


Version control
---------------
- 0.1 (2014032600)
-- first release


=================================================================
copyright 2014 Matthias Schwabe - eLeDia GmbH <support@eledia.de>
license: http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

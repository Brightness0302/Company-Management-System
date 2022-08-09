<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */

// INSERT INTO `projects`(`id`, `category`, `url`, `featured`, `slideshowimage`, `name`, `location`, `investor`, `author`, `collaborators`, `year`, `square`, `status`, `text`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]','[value-12]','[value-13]','[value-14]')Prethodni Kuca_r Sljedeći Frequency Store


defined('BASEPATH') OR exit('No direct script access allowed');

$lang['proj.proj_sel'] = 'Selected Projects';
$lang['proj.proj_all'] = 'All Projects';
$lang['proj.proj_public'] = 'Public';
$lang['proj.proj_culture'] = 'Culture';
$lang['proj.proj_housing'] = 'House';
$lang['proj.proj_business'] = 'Business';
$lang['proj.proj_tenders'] = 'Tenders';
$lang['proj.proj_interior'] = 'Interior';

$lang['proj.home'] = 'Home';
$lang['proj.projects'] = 'Projects';
$lang['proj.finest'] = 'Finest of Croatia';
$lang['proj.products'] = 'Products';
$lang['proj.studio'] = 'Studio';
$lang['proj.news'] = 'News / Press';
$lang['proj.contact'] = 'Contact';

$lang['proj.proj_name'] = 'Project Name';
$lang['proj.proj_location'] = 'location';
$lang['proj.proj_investor'] = 'investor';
$lang['proj.proj_author'] = 'author';
$lang['proj.proj_collaborators'] = 'collaborators';
$lang['proj.proj_year'] = 'year';
$lang['proj.proj_square'] = 'square';
$lang['proj.proj_status'] = 'status';
$lang['proj.proj_more'] = 'more';
$lang['proj.proj_description'] = 'description';
$lang['proj.prev'] = 'Prev';
$lang['proj.next'] = 'Next'; 
 
$lang['db.no'] = 'No';
$lang['db.name'] = 'Name';
$lang['db.category'] = 'Category';
$lang['db.featured'] = 'Featured';
$lang['db.product'] = 'Product';
$lang['db.slideshowimage'] = 'SlideShow';
$lang['db.finest'] = 'Finest';
$lang['db.location'] = 'Location';
$lang['db.investor'] = 'Investor';
$lang['db.collaborator'] = 'Collaborator';
$lang['db.description'] = 'Description';
$lang['db.year'] = 'Year';
$lang['db.square'] = 'Square';
$lang['db.options'] = 'Options';
$lang['db.author'] = 'Author';
$lang['db.status'] = 'Status';

$lang['manage.edit'] = 'Edit';
$lang['manage.delete'] = 'Delete';
$lang['manage.add'] = 'Add New + ';
$lang['manage.title'] = 'Projects manager';
$lang['manage.wrongsentence'] = 'Something is wrong.';
$lang['manage.confirmsentence'] = 'Are you Sure?';

$lang['upload.uploadimage'] = 'Upload Image';
$lang['upload.clearqueue'] = 'Clear Queue';
$lang['upload.imagecount'] = 'Image Count';
$lang['upload.save'] = 'Save';
$lang['upload.cancel'] = 'Cancel';

$lang['edit.editpage'] = 'Edit Page';
$lang['edit.createpage'] = 'Create Page';
$lang['edit.active'] = 'Active';
$lang['edit.inactive'] = 'Non Active';
$lang['edit.culture'] = 'Culture';
$lang['edit.public'] = 'Public';
$lang['edit.business'] = 'Business';
$lang['edit.interior'] = 'Interior';
$lang['edit.house'] = 'House';
$lang['edit.tender'] = 'Tenders';

$lang['main.more'] = 'More about the project';

$lang['mproj.gotostudio'] = 'Studio';
$lang['mproj.gotoproject'] = 'Projects';
$lang['mproj.title'] = 'Studio_TimeLine Manager';
$lang['mproj.name'] = 'Name';
$lang['mproj.year'] = 'Year';
$lang['mproj.description'] = 'Description';

$lang['mproj.gototimeline'] = 'TimeLine';
$lang['mproj.gotoemployee'] = 'Employee';
$lang['mproj.employee_title'] = 'Studio_Employee Manager';
$lang['mproj.name'] = 'Name';
$lang['mproj.state'] = 'State';
$lang['mproj.facebook'] = 'FaceBook';
$lang['mproj.twitter'] = 'Twitter';
$lang['mproj.linkedin'] = 'Linkedin';

$lang['url.url1'] = 'en/projects/show/featured';
$lang['url.url2'] = 'en/projects/show/product';
$lang['url.url3'] = 'en/projects/listprojects';
$lang['url.url4'] = 'en/projects/category/Public';
$lang['url.url5'] = 'en/projects/category/Culture';
$lang['url.url6'] = 'en/projects/category/House';
$lang['url.url7'] = 'en/projects/category/Business';
$lang['url.url8'] = 'en/projects/category/Tenders';
$lang['url.url9'] = 'en/projects/category/Interior';
$lang['url.url10'] = 'en/projects/show/finest';
$lang['url.url11'] = 'en/projects/clickstudio';
$lang['url.url12'] = 'en/projects/press';
$lang['url.url13'] = 'en/Home/contact';
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

$lang['proj.proj_sel'] = 'Odabrani projekti';
$lang['proj.proj_all'] = 'Svi projekti';
$lang['proj.proj_public'] = 'Javno';
$lang['proj.proj_culture'] = 'Kultura';
$lang['proj.proj_housing'] = 'Stanovanje';
$lang['proj.proj_business'] = 'Poslovno';
$lang['proj.proj_tenders'] = 'Natječaji';
$lang['proj.proj_interior'] = 'Interijer';

$lang['proj.home'] = 'Početna';
$lang['proj.projects'] = 'Projekti';
$lang['proj.finest'] = 'Finest of Croatia';
$lang['proj.products'] = 'Produkti';
$lang['proj.studio'] = 'Studio';
$lang['proj.news'] = 'Novosti / Press';
$lang['proj.contact'] = 'Kontakt';

$lang['proj.proj_name'] = 'Project Name';
$lang['proj.proj_location'] = 'lokacija';
$lang['proj.proj_investor'] = 'investitor';
$lang['proj.proj_author'] = 'autor(i)';
$lang['proj.proj_collaborators'] = 'suradnici';
$lang['proj.proj_year'] = 'godina';
$lang['proj.proj_square'] = 'površina';
$lang['proj.proj_status'] = 'status';
$lang['proj.proj_more'] = 'Više';
$lang['proj.proj_description'] = 'opis projekta';
$lang['proj.prev'] = 'Prethodni';
$lang['proj.next'] = 'Sljedeći'; 

$lang['db.no'] = 'Ne';
$lang['db.name'] = 'Ime';
$lang['db.category'] = 'Kategorija';
$lang['db.featured'] = 'Istaknuto';
$lang['db.product'] = 'Proizvod';
$lang['db.slideshowimage'] = 'Slideshow';
$lang['db.finest'] = 'Najbolji';
$lang['db.location'] = 'Mjesto';
$lang['db.investor'] = 'Investitor';
$lang['db.collaborator'] = 'Suradnik';
$lang['db.description'] = 'Opis';
$lang['db.year'] = 'Godina';
$lang['db.square'] = 'Kvadrat';
$lang['db.options'] = 'Mogućnosti';
$lang['db.author'] = 'Autor';
$lang['db.status'] = 'Status';

$lang['manage.edit'] = 'Uredi';
$lang['manage.delete'] = 'Izbrisati';
$lang['manage.add'] = 'Dodaj novi + ';
$lang['manage.title'] = 'Voditeljica projekata';
$lang['manage.wrongsentence'] = 'Nešto nije u redu.';
$lang['manage.confirmsentence'] = 'Jesi li siguran?';

$lang['upload.uploadimage'] = 'Prenesite slike';
$lang['upload.clearqueue'] = 'Očisti red čekanja';
$lang['upload.imagecount'] = 'Broj slika';
$lang['upload.save'] = 'Uštedjeti';
$lang['upload.cancel'] = 'Otkazati';

$lang['edit.editpage'] = 'Uredi stranicu';
$lang['edit.createpage'] = 'Napravi stranicu';
$lang['edit.active'] = 'Aktivan';
$lang['edit.inactive'] = 'Neaktivan';
$lang['edit.culture'] = 'Kultura';
$lang['edit.public'] = 'Javnost';
$lang['edit.business'] = 'Poslovanje';
$lang['edit.interior'] = 'Interijer';
$lang['edit.house'] = 'Kuća';
$lang['edit.tender'] = 'Natječaji';

$lang['main.more'] = 'Više o projektu';

$lang['mproj.gotostudio'] = 'Studio';
$lang['mproj.gotoproject'] = 'Projekata';
$lang['mproj.title'] = 'Studio_TimeLine Manager';
$lang['mproj.name'] = 'Ime';
$lang['mproj.year'] = 'Godina';
$lang['mproj.description'] = 'Opis';

$lang['mproj.gototimeline'] = 'Vremenska Crta';
$lang['mproj.gotoemployee'] = 'Zaposlenik';
$lang['mproj.employee_title'] = 'Studio_Employee Manager';
$lang['mproj.name'] = 'Ime';
$lang['mproj.state'] = 'država';
$lang['mproj.facebook'] = 'FaceBook';
$lang['mproj.twitter'] = 'Twitter';
$lang['mproj.linkedin'] = 'Linkedin';

$lang['url.url1'] = 'hr/projekti/emisija/istaknuti';
$lang['url.url2'] = 'hr/projekti/emisija/proizvod';
$lang['url.url3'] = 'hr/projekti/listprojekti';
$lang['url.url4'] = 'hr/projekti/kategorija/javni';
$lang['url.url5'] = 'hr/projekti/kategorija/kultura';
$lang['url.url6'] = 'hr/projekti/kategorija/Kuca';
$lang['url.url7'] = 'hr/projekti/kategorija/biznis';
$lang['url.url8'] = 'hr/projekti/kategorija/Natječaji';
$lang['url.url9'] = 'hr/projekti/kategorija/interijer';
$lang['url.url10'] = 'hr/projekti/show/najbolji';
$lang['url.url11'] = 'hr/projekti/clickstudio';
$lang['url.url12'] = 'hr/projekti/tisak';
$lang['url.url13'] = 'hr/Dom/kontakt';
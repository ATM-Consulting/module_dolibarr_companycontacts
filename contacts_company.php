<?php
/* Copyright (C) 2005 		Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2010 		Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2010-2011 	Regis Houssin        <regis.houssin@capnetworks.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * \file htdocs/societe/commerciaux.php
 * \ingroup societe
 * \brief Page of links to sales representatives
 */
$res = '';
$res = @include ("../main.inc.php"); // For root directory
if (! $res)
	$res = @include ("../../main.inc.php"); // For "custom" directory

require_once DOL_DOCUMENT_ROOT.'/contact/class/contact.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/contact.lib.php';


require_once ("./class/actions_companycontacts.class.php");

$langs->load("companies");
$langs->load("other");

// Security check
$id		= GETPOST('id','int');

// Security check
if ($user->societe_id) $socid=$user->societe_id;
$result = restrictedArea($user, 'contact', $id, 'socpeople&societe');

$hookmanager->initHooks(array (
		'companycontacts' 
));

$object = new Contact($db);
$object->fetch($id, $user);

/*
 *	Actions
 */
$parameters = array (
		'socid' => GETPOST('socid') 
);
$reshook = $hookmanager->executeHooks('doActions', $parameters, $soc, $action); // Note that $action and $object may have been modified by some hooks
$error = $hookmanager->error;
$errors = array_merge($errors, ( array ) $hookmanager->errors);

/*
 *	View
 */

$help_url = 'EN:Module_Third_Parties|FR:Module_Tiers|ES:Empresas';
llxHeader('', $langs->trans("ThirdParty"), $help_url);

$form = new Form($db);
// $formcompany = new FormCompany($db);

$head = contact_prepare_head($object);

dol_fiche_head($head, 'companycontacts', $langs->trans("Contacts"), 0, 'contact');

/*
	 * Fiche societe en mode visu
	 */

print '<table class="border" width="100%">';

$linkback = '<a href="' . DOL_URL_ROOT . '/contact/list.php">' . $langs->trans("BackToList") . '</a>';

// Ref
print '<tr><td width="20%">' . $langs->trans("Ref") . '</td><td colspan="3">';
print $form->showrefnav($object, 'id', $linkback);
print '</td></tr>';

// Name
print '<tr><td width="20%">' . $langs->trans("Lastname") . ' / ' . $langs->trans("Label") . '</td><td width="30%">' . $object->lastname . '</td>';
print '<td width="20%">' . $langs->trans("Firstname") . '</td><td width="30%">' . $object->firstname . '</td></tr>';

// Company
if (empty($conf->global->SOCIETE_DISABLE_CONTACTS)) {
	if ($object->socid > 0) {
		$objsoc = new Societe($db);
		$objsoc->fetch($object->socid);
		
		print '<tr><td>' . $langs->trans("Company") . '</td><td colspan="3">' . $objsoc->getNomUrl(1) . '</td></tr>';
	} 

	else {
		print '<tr><td>' . $langs->trans("Company") . '</td><td colspan="3">';
		print $langs->trans("ContactNotLinkedToCompany");
		print '</td></tr>';
	}
}

// Civility
print '<tr><td>' . $langs->trans("UserTitle") . '</td><td colspan="3">';
print $object->getCivilityLabel();
print '</td></tr>';

// Date To Birth
print '<tr>';
if (! empty($object->birthday)) {
	include_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
	
	print '<td>' . $langs->trans("DateToBirth") . '</td><td colspan="3">' . dol_print_date($object->birthday, "day");
	
	print ' &nbsp; ';
	// var_dump($birthdatearray);
	$ageyear = convertSecondToTime($now - $object->birthday, 'year') - 1970;
	$agemonth = convertSecondToTime($now - $object->birthday, 'month') - 1;
	if ($ageyear >= 2)
		print '(' . $ageyear . ' ' . $langs->trans("DurationYears") . ')';
	else if ($agemonth >= 2)
		print '(' . $agemonth . ' ' . $langs->trans("DurationMonths") . ')';
	else
		print '(' . $agemonth . ' ' . $langs->trans("DurationMonth") . ')';
	
	print ' &nbsp; - &nbsp; ';
	if ($object->birthday_alert)
		print $langs->trans("BirthdayAlertOn");
	else
		print $langs->trans("BirthdayAlertOff");
	print '</td>';
} else {
	print '<td>' . $langs->trans("DateToBirth") . '</td><td colspan="3">' . $langs->trans("Unknown") . "</td>";
}
print "</tr>";

print "</table>";
print "</div>\n";

	/*
		 * Liste
		 *
		 */
	
	$langs->load("contactfunction@contactfunction");
	
	$sql = "SELECT c.rowid,p.rowid as contact_id ";
	$sql .= ", p.firstname, p.lastname";
	$sql .= ", dep.label as department_label";
	$sql .= ", fun.label as function_label";
	$sql .= ", c.fk_soc_source";
	$sql .= " FROM " . MAIN_DB_PREFIX . "company_contacts as c";
	$sql .= " LEFT JOIN " . MAIN_DB_PREFIX . "socpeople as p ON p.rowid=c.fk_contact";
	$sql .= " LEFT JOIN " . MAIN_DB_PREFIX . "c_contact_function as fun ON fun.code=c.function_code";
	$sql .= " LEFT JOIN " . MAIN_DB_PREFIX . "c_contact_department as dep ON dep.code=c.department_code";
	$sql .= " WHERE c.entity IN (0," . $conf->entity . ")";
	$sql .= " AND p.rowid='" . $id . "'";
	$sql .= " ORDER BY c.rowid ASC ";
	
	$resql = $db->query($sql);
	if ($resql) {
		$num = $db->num_rows($resql);
		$i = 0;
		
		$title = $langs->trans("ListOfThirdPartyLinked");
		print_titre($title);
		
		// Lignes des titres
		print '<table class="noborder" width="100%">';
		print '<tr class="liste_titre">';
		print '<td>' . $langs->trans("ThirdParty") . '</td>';
		print "</tr>\n";
		
		$var = True;
		
		while ( $i < $num ) {
			$obj = $db->fetch_object($resql);
			$var = ! $var;
			
			print "<tr " . $bc[$var] . "><td>";
			$soc=new Societe($db);
			$result=$soc->fetch($obj->fk_soc_source);
			if ($result<0) {
				setEventMessage($soc->error,'errors');
			}
			print $soc->getNomUrl(1);
			print '</td>';
			print '</tr>' . "\n";
			$i ++;
		}
		
		print "</table>";
		$db->free($resql);
	} else {
		dol_print_error($db);
	}

$db->close();

llxFooter();

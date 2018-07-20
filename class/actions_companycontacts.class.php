<?php
/* <one line to give the program's name and a brief idea of what it does.>
 * Copyright (C) 2013  Jean-François Ferry <jfefe@aternatik.fr>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * 	\file		class/actions_companycontacts.class.php
 * 	\ingroup	companycontacts
 * 	\brief		This file is an example CRUD class file (Create/Read/Update/Delete)
 * 				Put some comments here
 */
// Put here all includes required by your class file
//require_once DOL_DOCUMENT_ROOT."/core/class/commonobject.class.php";
//require_once DOL_DOCUMENT_ROOT."/societe/class/societe.class.php";
require_once "companycontacts.class.php";


/**
 * Actions classs for companycontacts module
 */
class ActionsCompanycontacts // extends CommonObject
{

    private $db; //!< To store db handler
    public $error; //!< To return error code (or message)
    public $errors = array(); //!< To return several error codes (or messages)

    public $mysaveddao;


  	/**
	 *	Constructor.
	 *
	 *	@param	DoliDB	$db		Datatables handler
	 */
	function __construct($db)
	{
		$this->db = $db;
		$this->errors = array();
	}

	/**
	 *
	 */
	function getInstanceDao()
	{
		if (! is_object($this->mysaveddao))
		{
			$mydao=new Companycontacts($this->db);
			$this->mysaveddao=$mydao;
		}
		else
		{
			$mydao=$this->mysaveddao;
		}
		return $mydao;
	}

	/**
	 *	Return action of hook
	 *
	 *	@param	object			Linked object
	 */
	function doActions($parameters=false,&$object,&$action='')
	{
		global $user;
		if (($object->element == 'societe' ) )
		{
			if ($action == 'add_contact_link')
			{
				$link_contact = $this->getInstanceDao($db);
				$link_contact->fk_soc_source = GETPOST('socid');
				$link_contact->fk_soc = GETPOST('fk_soc');
				$link_contact->fk_contact = GETPOST('fk_contact');
				$link_contact->function_code = GETPOST('function_code');
				$link_contact->department_code = GETPOST('department_code');
				$link_contact->datec=dol_now();
				$res = $link_contact->create($user);
				if($res > 0)
				{
					setEventMessage('ContactLinkedWithCompanySuccessfully');
				}
				else
				{
					setEventMessage('KO !!!!!!');
				}
			}

			// Efface un contact
			if ($action == 'delete_contact_link' && $user->rights->companycontacts->write)
			{
				$link_contact = $this->getInstanceDao($db);
				$res = $link_contact->fetch(GETPOST('lineid'));
				if($res)
				{
					$result = $link_contact->delete($user,GETPOST('lineid'));

					if ($result >= 0)
					{
						setEventMessage('ContactCompanyLinkDeletedWithSuccess');
						Header("Location: ".$_SERVER['PHP_SELF']."?socid=".$object->id);
						exit;
					}

				}
				else {
					setEventMessage('ErrorWhenFetchContact','error');
				}
			}

			// Efface un contact
			if ($action == 'update_contact_link' && $user->rights->companycontacts->delete)
			{
				$this->dao = $this->getInstanceDao($db);
				$res = $this->dao->fetch(GETPOST('lineid'));
				if($res)
				{
					$this->dao->fk_soc_source = GETPOST('socid');
					$this->dao->fk_soc = GETPOST('fk_soc');
					$this->dao->fk_contact = GETPOST('fk_contact');
					$this->dao->function_code = GETPOST('function_code');
					$this->dao->department_code = GETPOST('department_code');

					$result = $this->dao->update($user);

					if ($result >= 0)
					{
						setEventMessage('ContactCompanyLinkUpdated');
						Header("Location: ".$_SERVER['PHP_SELF']."?socid=".$object->id);
						exit;
					}
					else
					{
						setEventMessage($this->dao->error);
					}

				}
				else {
					setEventMessage('ErrorWhenFetchContact','errors');
				}
			}


		}
	}

}

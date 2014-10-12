<?php
/*
Whois.php        PHP classes to conduct whois queries

Copyright (C)1999,2005 easyDNS Technologies Inc. & Mark Jeftovic

Maintained by David Saez (david@ols.es)

For the most recent version of this package visit:

http://www.phpwhois.org

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

if (!defined('__LT_HANDLER__'))
	define('__LT_HANDLER__', 1);

require_once('whois.parser.php');

class lt_handler
	{

	function parse($data_str, $query)
		{

		$translate = array(
					'contact nic-hdl:' => 'handle',
					'contact name:' => 'name'
					);

		$items = array(
						'admin' 			=> 'Contact type:      Admin',
						'tech'				=> 'Contact type:      Tech',
						'zone'				=> 'Contact type:      Zone',
						'owner.name'		=> 'Registrar:',
						'owner.email'		=> 'Registrar email:',
						'domain.status' 	=> 'Status:',
						'domain.created'	=> 'Registered:',
						'domain.changed'	=> 'Last updated:',
						'domain.nserver.'	=> 'NS:',
						''		=> '%'
						);

		$r['regrinfo'] = get_blocks($data_str['rawdata'], $items);

		if (isset($r['regrinfo']['admin']))
			$r['regrinfo']['admin'] = get_contact($r['regrinfo']['admin'],$translate);
			
		if (isset($r['regrinfo']['tech']))
			$r['regrinfo']['tech'] = get_contact($r['regrinfo']['tech'],$translate);
			
		if (isset($r['regrinfo']['zone']))
			$r['regrinfo']['zone'] = get_contact($r['regrinfo']['zone'],$translate);

		$r = format_dates($r,'ymd');

		$r['regyinfo'] = array(
                    'referrer' => 'http://www.domreg.lt',
                    'registrar' => 'DOMREG.LT'
                    );

		return ($r);
		}
	}
?>

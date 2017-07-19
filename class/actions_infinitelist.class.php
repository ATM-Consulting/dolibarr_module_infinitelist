<?php
/* <one line to give the program's name and a brief idea of what it does.>
 * Copyright (C) 2015 ATM Consulting <support@atm-consulting.fr>
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
 * \file    class/actions_infinitelist.class.php
 * \ingroup infinitelist
 * \brief   This file is an example hook overload class file
 *          Put some comments here
 */

/**
 * Class Actionsinfinitelist
 */
class Actionsinfinitelist
{
	/**
	 * @var array Hook results. Propagated to $hookmanager->resArray for later reuse
	 */
	public $results = array();

	/**
	 * @var string String displayed by executeHook() immediately after return
	 */
	public $resprints;

	/**
	 * @var array Errors
	 */
	public $errors = array();

	/**
	 * Constructor
	 */
	public function __construct()
	{
	}
	
	function doActions($parameters, &$object, &$action, $hookmanager)
	{
		
		if (strpos($parameters['context'],'list' ) !==false)
		{
			/*
			global $conf;
			$conf->dol_optimize_smallscreen = 999999;
			*/
		}
	
		
	}
	/**
	 * Overloading the doActions function : replacing the parent's function with the one below
	 *
	 * @param   array()         $parameters     Hook metadatas (context, etc...)
	 * @param   CommonObject    &$object        The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param   string          &$action        Current action (if set). Generally create or edit or null
	 * @param   HookManager     $hookmanager    Hook manager propagated to allow calling another hook
	 * @return  int                             < 0 on error, 0 on success, 1 to replace standard code
	 */
	function printFieldListOption($parameters, &$object, &$action, $hookmanager)
	{
		
		if (strpos($parameters['context'],'list' ) !==false)
		{
			global $langs;
		
			?>
			<script type="text/javascript" src="<?php echo dol_buildpath('/infinitelist/js/purl.js', 1)?>"></script>
			<script type="text/javascript">
			$(document).ready(function() {
				function getUrlParameter(url, sParam) {

					var sURL = url.split('?');
					sPageURL = sURL[1];
					
				    var sURLVariables = sPageURL.split('&'),
				    sParameterName,
				    i;

				    for (i = 0; i < sURLVariables.length; i++) {
				        sParameterName = sURLVariables[i].split('=');

				        if (sParameterName[0] === sParam) {
				            return sParameterName[1] === undefined ? true : sParameterName[1];
				        }
				    }
				}
				
				$pagination = $('div.pagination');
				var nb_page_more =$pagination.find('>ul>li>a').length;  
				if(nb_page_more>0) {
					var $table = $('table.liste');
					$table.after('<div id="loadMorePageItem"><?php echo $langs->trans('LoadMore') ?></div>');
					var current_page = 0;
					$pagination.find('.paginationnext').remove();
					$pagination.hide();

					var base_url = $pagination.find('>ul a:last').attr('href');
					
					var maximumPage = getUrlParameter(base_url,'page');

					var parsedUrl = $.url(base_url);
					var params = parsedUrl.param();
					delete params["page"];
					
					$(window).scroll(function() {

						if($("#loadMorePageItem")) {
						
						    var top_of_element = $("#loadMorePageItem").offset().top;
						    var bottom_of_element = $("#loadMorePageItem").offset().top + $("#loadMorePageItem").outerHeight();
						    var bottom_of_screen = $(window).scrollTop() + $(window).height();
						    var top_of_screen = $(window).scrollTop();
	
						    if((bottom_of_screen > top_of_element) && (top_of_screen < bottom_of_element)){
						    	$("#loadMorePageItem").remove();
						    	current_page++;
						    	var newUrl = "?page=" +current_page + "&" + $.param(params);
						    	
								$.ajax({
									url:newUrl
								}).done(function(html) {
	
									$tr = $(html).find('table.liste tr.oddeven');
	
									$table.append($tr);								
									
									if(current_page < maximumPage) {
										$table.after('<div id="loadMorePageItem"><?php echo $langs->trans('LoadMore') ?></div>');
									}
								});
	
					    	
						    	    	
	
							}

						}
					   
					});
					
				}				
				
			});
			</script><?php 
			
		}

		
	}
}
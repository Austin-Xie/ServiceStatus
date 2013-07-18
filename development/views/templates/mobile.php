<rn:meta javascript_module="mobile_may_10"/>
<!DOCTYPE html>
<html lang="#rn:language_code#">
    <head>
        <meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1.0; maximum-scale=1.0; user-scalable=no;"/>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <meta http-equiv="Content-Style-Type" content="text/css"/>
        <meta http-equiv="Content-Script-Type" content="text/javascript"/>
        <title><rn:page_title/></title>
        <rn:theme path="/euf/assets/themes/mobile" css="site.css,/rnt/rnw/yui_2.7/container/assets/skins/sam/container.css"/>
        <rn:head_content/>
        <link rel="icon" href="images/favicon.png" type="image/png">
				
				<meta name="author" content="Singtel Optus">
				<meta name="site" content="personal">
				<meta name="keywords" content="optus, customer help centre, products, services, billing, accounts, faqs, guides">
				<meta name="description" content="Customer help on Optus home products and services. Questions and answers on billing and accounts, home phone, mobile phone and internet related topics.">

				<meta http-equiv="content-language" content="en">
				
				<?php
					// $selected_product='';
					$page_type = ''; // "Landing Page", "Product List", "Product Detail", "Answers List", "Answers Detail"
					$breadcrumbs = array('Home','consumer','Help & Support');
					$section = '';
					
					$requestURL = $_ENV["REQUEST_URI"];
					if (strstr($requestURL,"/app/product/list")) {
						$page_type = "Product List";
						if (strstr($requestURL,"/p/766")) {
							$section = "Prepaid Mobile";
						} else if (strstr($requestURL,"/p/773")) {
							$section = "Postpaid Mobile";
						} else if (strstr($requestURL,"/p/780")) {
							$section = "Home Phone";
						} else if (strstr($requestURL,"/p/781")) {
							$section = "DSL Broadband";
						} else if (strstr($requestURL,"/p/782")) {
							$section = "Cable Broadband";
						} else if (strstr($requestURL,"/p/783")) {
							$section = "Postpaid Mobile Broadband";
						} else if (strstr($requestURL,"/p/784")) {
							$section = "Prepaid Mobile Broadband";
						} else if (strstr($requestURL,"/p/785")) {
							$section = "Digital TV";
						} else if (strstr($requestURL,"/p/901")) {
							$section = "Optus Me TV";
						}
					} else if (strstr($requestURL,"/app/product/detail")) {
						$page_type = "Product Detail";
					} else if (strstr($requestURL,"/app/answers/list")) {
						$page_type = "Answers List";
						if (stristr($requestURL,"accounts%20and%20billing")) {
							$section = "Accounts & Billing";
						} else {
							$section = "Search Results";
						}
						
						if (strstr($requestURL,"/c/774")) {
							$enquiry_type = "Billing & Payments";
						} else if (strstr($requestURL,"/c/768")) {
							$enquiry_type = "Product Information";
						} else if (strstr($requestURL,"/c/769")) {	
							$enquiry_type = "Technical Support";
						} else if (strstr($requestURL,"/c/770")) {
							$enquiry_type = "Buying & Activating";
						} else if (strstr($requestURL,"/c/771")) {	
							$enquiry_type = "My Account - Online";
						} else if (strstr($requestURL,"/c/772")) {	
							$enquiry_type = "General Information";
						}
						
					} else if (strstr($requestURL,"/app/answers/detail")) {
						$page_type = "Answers Detail";
						$section = getDynamicTitle('answer', getUrlParm('a_id'));
					} else if (strstr($requestURL,"/app/ask_confirm")) {
						$page_type = "Ask Confirm";
						$section = "Contact Us Confirmation";
					} else if (strstr($requestURL,"/app/ask")) {
						$page_type = "Ask";
						$section = "Contact Us Form";
					} else if (strstr($requestURL,"/app")) {
						$page_type = "Landing Page";
						$section = "Home";
					} else {
						$page_type = "Other";
						$section = "Other";
					}
					
					$GLOBALS['page_type'] = $page_type;
					$GLOBALS['section'] = $section;
					
					array_push($breadcrumbs, $section);
					
					$channel_str = implode ('|', $breadcrumbs);
				?>
				
				<meta content="<? echo json_encode($channel_str) ?>" name="channel" />	
				
				<!--
				<link media="all" href="https://smb.optus.com.au/opfiles/OnePortal/lib/css/shared/fluid.gs.css" type="text/css" rel="stylesheet" />

				<link media="all" href="https://smb.optus.com.au/opfiles/cc/static/assets/common/css/globalHeader.css" type="text/css" rel="stylesheet" />
				
				<link media="all" href="https://smb.optus.com.au/opfiles/OnePortal/lib/css/oca/personal/layout.css" type="text/css" rel="stylesheet" />
				<link media="all" href="https://smb.optus.com.au/opfiles/OnePortal/lib/css/oca/personal/skin.css" type="text/css" rel="stylesheet" />

				<link media="all" href="https://smb.optus.com.au/opfiles/OnePortal/lib/css/shared/core.css" type="text/css" rel="stylesheet" />
				-->
    </head>
    <body>
        <noscript><h1>#rn:msg:SCRIPTING_ENABLED_SITE_MSG#</h1></noscript>
				
				<script type="text/javascript">/*<![CDATA[*/
					window.Config = window.Config || {};
					Config.debugLevel = 0; 
					Config.assetRoot = "//www.optus.com.au/opfiles/OnePortal"; 
					Config.webRoot = "/opfiles"; 
					Config.jsFolder = "js";  
					Config.metaInfoTitle = "Optus | Mobile Phones, Plans, Broadband & Mobile Broadband";  
					Config.pageTitle = "";
					Config.currentDomain = "consumer";
					Config.isPersonalSite = true;
					Config.isBusinessSite = false;
					Config.EventTracker = { "enabled": true };
					Config.breadcrumbs = <? echo json_encode($breadcrumbs) ?>;
					Config.sqCheck = "";
					
					Config.isDev = false;
					Config.isProd = true;
					
					
					var lpMTagConfig = {};
					lpMTagConfig.lpNumber = Config.isProd ? "65298410" : "61577460";
					
					function passLPvariable (name, data){
						if (name && data){
							var eventData = {
								eventType: 'trackCustHelpArticle',
								eventTrigger: 'load',
								name: name,
								data: data
							};
							EventTracker.trackCustHelpArticle(eventData);
						}
					}
					
					var oca = window.oca || {};
					oca.appContext = 'shop';
					
					/*
					oca.config = {};
					oca.config.environment = "prod";
					
					window.marketSegment = {};
					window.marketSegment.isBusiness = false;
					*/
				/*]]>*/</script>
        
				<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"> </script>
		
				<script type="text/javascript" src="http://www.optus.com.au/opfiles/OnePortal/lib/js_min/shared.js"> </script>
				<!---<script type="text/javascript" src="http://indra-dev.optus.com.au/mcas/portal/OnePortal/frontend/trunk/vault/onePortal/opfiles/OnePortal/lib/js_min/shared.js"> </script>--->
				
				<script type="text/javascript">/*<![CDATA[*/
					
					// Manually remove chat_roundbox
					$(document).ready(function(){
					});
					
					EventTracker.bind('load', function(){
						$.whenPage('load', function(){
							// function: getSearchPhrase
							var getSearchPhrase = function() {
								var searchPhrase = $('.rn_SearchInput_element_container input').val() || '-';
								return searchPhrase;
							};
							
							// function: getSelectionValue
							var getSelectionValue = function() {
								var categorySearchFilterSpanElem = $(".rn_ProductCategorySearchFilter button:first span[id^=rn_ProductCategorySearchFilter]"),
									categorySearchFilterVal = categorySearchFilterSpanElem.text() || '-';
								return categorySearchFilterVal;
							};
							
							// The value in the search field
							passLPvariable('HSSearch', getSearchPhrase());
							
							// The value in the selection dropdown
							passLPvariable('HSDropdown', getSelectionValue());
							
							// Answers List triggers
							<? if ($page_type == "Answers List") { ?>
								// Upon Search button click
								var searchButtonElem = $('.rn_SubmitButton');
								
								searchButtonElem.click(function() {
									passLPvariable('HSSearch', getSearchPhrase());
									passLPvariable('HSDropdown', getSelectionValue());
								});
							<? } ?>
							
							// Answers Detail triggers
							<? if ($page_type == "Answers Detail") { ?>
								// Article Number
								var articleIdElem = $("#article_id");
								passLPvariable('ArticleNumber',articleIdElem.text());
								
								// Article Name
								var mainPageContentsTitle = $(".main_page_contents > h1:first,.main_page_contents > h3:first"),
										articleName = (mainPageContentsTitle.length && mainPageContentsTitle.text().replace(/^\s*Q.\s+/i,'')) || '-';
								
								passLPvariable('ArticleName',articleName);
								
								// Section and Enquiry Type
								$(".rn_ProductCategoryDisplay").each(function(){
									var productCategoryDisplay = $(this), 
											type = $.trim( productCategoryDisplay.find('.rn_DataLabel').text() ),
											varType = ((type === "Products") && "Section") || ((type === "Categories") && "EnquiryType");
									
									if (varType) {
										var vals = [];
										
										productCategoryDisplay.find(".rn_DataValue li").each(function(){
											vals.push( $.trim( $(this).text() ) );
										});
										
										passLPvariable(varType,vals.join(','));
									}
								});
								
								// Article Helpful (Yes/No Rating)
								// Reset
								passLPvariable('ArticleHelpful',"-");
								
								var ratingButtons = $('.feedback_container').find('button.yes,button.no');
								
								var ratingButtonsHandler = function(){
									var val = $.trim( $(this).attr('class') );
									
									// capitalise the word. e.g. yes -> Yes
									val = val.charAt(0).toUpperCase() + val.substr(1).toLowerCase();
									
									passLPvariable('ArticleHelpful',val);
									
									// unbind event as ratings are only submitted to LivePerson once.
									ratingButtons.unbind('click', ratingButtonsHandler);
								};
								
								ratingButtons.bind('click', ratingButtonsHandler);
							<? } else { ?>
								// Non "Answers Detail" triggers
								
								var	breadcrumbs = Config.breadcrumbs,
										section = breadcrumbs[3];
										val = 'HS-' + (section + '').replace(/\&\s/g,"").replace(/\s/g,"-");
									
								passLPvariable('Section',val);
								
								var enq_type = <? echo json_encode($enquiry_type) ?> || '-';
								passLPvariable('EnquiryType', enq_type);
								
								passLPvariable('ArticleNumber',"-");
								passLPvariable('ArticleName',"-");
								passLPvariable('ArticleHelpful',"-");
								
							<? } ?>
							
						});
						
					});
					
					if(typeof(oca) == "undefined") var oca = {};
					
					oca.globalHeader = {
						internal: true,
						environment: "prod",
						data: {} 
					}
					
					if(oca.config) oca.config.environment = "prod";
				/*]]>*/</script>
				
				<script type="text/javascript" charset="utf-8">/*<![CDATA[*/
					addEventListener('load', function() {
						setTimeout(hideAddressBar, 0);
						}, false);
					
					function hideAddressBar() {
						window.scrollTo(0, 1);
					}
				/*]]>*/</script>
				
				<!--
						<script type="text/javascript" src="https://smb.optus.com.au/opfiles/cc/static/assets/common/js/globalHeader.js"> </script>
		
		
		
		-->
				
				<?
					$src = $_GET['src'];
				
					$h = $_GET['h'];
					
					if ($h == "pre") {
						setcookie("h_id","766",0,"/");
					} elseif ($h == "post") {
						setcookie("h_id","773",0,"/");
					} elseif ($_COOKIE["h_id"] == "") {
						setcookie("h_id","773",0,"/");
					}
					
					$display_selector = true;
					
					if ($src == "") {
						if ($GLOBALS['src'] == "app"){
							$display_selector = false;
						}
					} else {
						setcookie("src",$src,0,"/");
						$GLOBALS['src'] = $src;
						
						if ($src == "app") {
							$display_selector = false;
						}
					}
					
				?>
				
				<header>
					<nav id="rn_Navigation">
						<? if ($GLOBALS['page_type'] != ''): ?>
							<rn:widget path="custom/mobile/Header" />
						<? elseif ($page_type == "Landing Page"): ?>
							<rn:widget path="custom/mobile/Header" page_type="Landing Page" />
						<? elseif ($page_type == "Product List"): ?>
							<rn:widget path="custom/mobile/Header" page_type="Product List" />
						<? elseif ($page_type == "Product Detail"): ?>
							<rn:widget path="custom/mobile/Header" page_type="Product Detail" />
						<? elseif ($page_type == "Answers List"): ?>
							<? if ($section == "Accounts & Billing"): ?>
								<rn:widget path="custom/mobile/Header" page_type="Answers List" section="Accounts & Billing" />
							<? else: ?>
								<rn:widget path="custom/mobile/Header" page_type="Answers List" />
							<? endif; ?>
						<? elseif ($page_type == "Answers Detail"): ?>
							<rn:widget path="custom/mobile/Header" page_type="Answers Detail" />
						<? endif; ?>
						
					</nav>
						<!--
            <rn:condition is_spider="false">
            <nav id="rn_Navigation">
								
                <span class="rn_FloatLeft">
                    <rn:widget path="navigation/MobileNavigationMenu" submenu="rn_MenuList"/>
                </span>
								
                <ul id="rn_MenuList" class="rn_Hidden">
                    <li>
                        <a href="/app/home#rn:session#">#rn:msg:HOME_LBL#</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="rn_ParentMenu">#rn:msg:CONTACT_US_LBL#</a>
                        <ul class="rn_Submenu rn_Hidden">
                            <li><a href="/app/chat/chat_launch#rn:session#">#rn:msg:CHAT_LBL#</a></li>
                            <li><a href="/app/ask#rn:session#">#rn:msg:EMAIL_US_LBL#</a></li>
                            <li><a href="javascript:void(0);">#rn:msg:CALL_US_DIRECTLY_LBL#</a></li>
                            <li><a href="javascript:void(0);">#rn:msg:ASK_THE_COMMUNITY_LBL#</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="rn_ParentMenu">#rn:msg:YOUR_ACCOUNT_LBL#</a>
                        <ul class="rn_Submenu rn_Hidden">
                            <rn:condition logged_in="false">
                            <li><a href="/app/utils/create_account#rn:session#">#rn:msg:SIGN_UP_LBL#</a></li>
                            <li><a href="/app/utils/login_form#rn:session#">#rn:msg:LOG_IN_LBL#</a></li>
                            <li><a href="/app/utils/account_assistance#rn:session#">#rn:msg:ACCOUNT_ASSISTANCE_LBL#</a></li>
                            </rn:condition>
                            <li><a href="/app/account/questions/list#rn:session#">#rn:msg:VIEW_YOUR_SUPPORT_HISTORY_CMD#</a></li>
                            <li><a href="/app/account/profile#rn:session#">#rn:msg:CHANGE_YOUR_ACCOUNT_SETTINGS_CMD#</a></li>
                        </ul>
                    </li>
                </ul>
								
                <span class="rn_FloatRight rn_Search">
                    <rn:widget path="navigation/MobileNavigationMenu" label_button="#rn:msg:SEARCH_LBL#<img src='images/search.png' alt='#rn:msg:SEARCH_LBL#'/>" submenu="rn_SearchForm"/>
                </span>
								
                <div id="rn_SearchForm" class="rn_Hidden">
                    <rn:widget path="search/MobileSimpleSearch" report_page_url="/app/answers/list"/>
                </div>
            </nav>
            </rn:condition>
						-->
						
        </header>

        <section>
            <rn:page_content/>
        </section>

        <footer>
				
				<script type="text/javascript">
					if (window.includeScript && window.includeScript.bodyFooterReached) {
						includeScript.bodyFooterReached();
					}
				</script>
				
            <rn:condition is_spider="false">
                <!--
								<div>
                    <rn:condition logged_in="true">
                    <rn:field name="contacts.email"/><rn:widget path="login/LogoutLink2"/>
                    <rn:condition_else />
                    <a href="/app/utils/login_form#rn:session#">#rn:msg:LOG_IN_LBL#</a>
                    </rn:condition>
                    <br/><br/>
                </div>
								-->
								
								<? if ($display_selector): ?>
									<rn:condition hide_on_pages="utils/guided_assistant">
											<rn:widget path="custom/utils/PageSetSelector"/>
									</rn:condition>
									<rn:widget path="custom/mobile/Footer" />
								<? endif; ?>
								
								<!--
                <div class="rn_FloatLeft"><a href="javascript:window.scrollTo(0, 0);">#rn:msg:ARR_BACK_TO_TOP_LBL#</a></div>
								-->
            </rn:condition>
						<!--
            <div class="rn_FloatRight">Powered by <a href="http://www.rightnow.com">RightNow</a></div>
						-->
            <br/><br/>
						
        </footer>
    </body>
</html>

<?php
function isIE6() {
  $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
  if (preg_match('/(?i)msie [123456]\./',$_SERVER['HTTP_USER_AGENT'])) {
	// if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.') !== FALSE)
	// if (ereg("msie 6.0", $userAgent)) {
    return true;
  } else {
    return false;
  }
}

if(isIE6()){
	// header("Cache-Control: no-cache");
	// header("Expires: -1");
?>
	
	<rn:widget path="utils/Templates/IEError" />
	
<?php
	exit();
} else {
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!-- <html class=" js" xmlns="http://www.w3.org/1999/xhtml" lang="#rn:language_code#" xml:lang="#rn:language_code#"> -->
<html xmlns="http://www.w3.org/1999/xhtml" lang="#rn:language_code#" xml:lang="#rn:language_code#">
	<head>

		<meta content="text/html;charset=UTF-8" http-equiv="Content-Type">
		<meta http-equiv="X-UA-Compatible" content="IE=8">
		<meta name="author" content="Singtel Optus">
		<meta name="site" content="personal">
		<meta name="keywords" content="optus, customer help centre, products, services, billing, accounts, faqs, guides">
		<meta name="description" content="Customer help on Optus home products and services. Questions and answers on billing and accounts, home phone, mobile phone and internet related topics.">
		<meta content="IE=edge" http-equiv="X-UA-Compatible">
		<title><rn:page_title/></title>

		<meta http-equiv="content-language" content="en">
		
		<?php
				// $selected_product='';
				$page_type = ''; // "Landing Page", "Product List", "Answers List", "Answers Detail", "Ask", "Ask Confirm"
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
						$section = "Optus TV with Fetch";
					}
				} else if (strstr($requestURL,"/app/answers/list")) {
					$page_type = "Answers List";
					if (strstr($requestURL,"accounts%20and%20billing")) {
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
				
				array_push($breadcrumbs, $section);
				
				$channel_str = implode ('|', $breadcrumbs);
		?>
		
		<meta content="<? echo json_encode($channel_str) ?>" name="channel" />	
		
		<meta content="no" http-equiv="imagetoolbar" /> <!-- disable the image menu that appears in IE -->
		
		<rn:widget path="search/BrowserSearchPlugin" pages="home, answers/list, answers/detail" />
		<rn:theme path="/euf/assets/themes/optus_theme" css="site.css,/rnt/rnw/yui_2.7/container/assets/skins/sam/container.css" />
		<rn:head_content/>				
		
		<link media="all" href="https://smb.optus.com.au/opfiles/OnePortal/lib/css/shared/fluid.gs.css" type="text/css" rel="stylesheet" />
		<link media="all" href="https://smb.optus.com.au/opfiles/OnePortal/lib/css/oca/personal/layout.css" type="text/css" rel="stylesheet" />
		<link media="all" href="https://smb.optus.com.au/opfiles/OnePortal/lib/css/oca/personal/skin.css" type="text/css" rel="stylesheet" />
		<link media="all" href="https://smb.optus.com.au/opfiles/OnePortal/lib/css/shared/core.css" type="text/css" rel="stylesheet" />
		
		<!-- Modifications for One Portal -->
		<style type="text/css">		
		@font-face {
			font-family: "OptusDINCondMediumRegular";
			font-style: normal;
			font-weight: normal;
			src: url("/euf/assets/fonts/optusdincond-medium-webfont.eot?#iefix") format("embedded-opentype"), url("/euf/assets/fonts/optusdincond-medium-webfont.woff") format("woff"), url("/euf/assets/fonts/optusdincond-medium-webfont.ttf") format("truetype"), url("/euf/assets/fonts/optusdincond-medium-webfont.svg#OptusDINCondMediumRegular") format("svg");
		}

		@font-face {
				font-family: "OptusDINCond-Medium";
				font-style: normal;
				font-weight: normal;
				src: url("/euf/assets/fonts/optusdincond-medium-webfont.eot?#iefix") format("embedded-opentype"), url("/euf/assets/fonts/optusdincond-medium-webfont.woff") format("woff"), url("/euf/assets/fonts/optusdincond-medium-webfont.ttf") format("truetype"), url("/euf/assets/fonts/optusdincond-medium-webfont.svg#OptusDINCondMediumRegular") format("svg");
		}

		.optus_logo {
			position: static;
		}
		.lhn {
			float: left;
			width: 200px; /*= 16.66em */
			padding-right: 40px; /*= 3.34em */
			margin-top: 1.67em; /* 20px */
		}
		.lhn_menu_l1_title {
			position: relative;
			z-index: 100;
			display: block;
			width: 170px; /* 8.49em */
			font-family: OptusDINCondMediumRegular,"Lucida Sans Unicode","Lucida Gande",sans-serif;
			font-size: 1.67em; /*= 20px */
			line-height: 1em;
			padding: 6px 15px 9px 15px; /*= .3em .75em .45em .75em */
			color: #fff;
			background: #eee; /* temporary. no colour yet */
			text-decoration: none;
			cursor: default;
		}
		.lhn_menu_l2_item {
			position: relative;
			margin-top: 1px;
			background: #e2e2e2;
			z-index: 98;
		}
		.lhn_menu_l2_item a,
		.lhn_menu_l2_item a:visited {
			position: relative;
			display: block;
			font-size: 1.09em;
			padding: 6px 15px 8px 15px; /*= .46em 1.15em .62em 1.15em */
			line-height: 1em;
			text-decoration: none;
			color: #555;
			z-index: 200;
		}
		.lhn_menu_l2_item a.active {
			font-weight:bold;
		}
		.lhn_menu_l2_item a:hover {
			background: #f2f2f2;
		}
		.lhn_menu_arrow {
			position: absolute;
			display: block;
			background: transparent url(https://www.optus.com.au/opfiles/OnePortal/images/shared/map_set_1.gif) no-repeat scroll 0 -59px;
			width: 13px;
			height: 7px;
			line-height: 0;
			top: -2px;
			*top: -3px;
			left: 6.73em; /*= 88px */
			_left: 5.6em; /*= 75px for IE6 */
			z-index: 99;
		}
		.lhn {
			padding-left: 4px !important;
			padding-right: 10px !important;
		}
		
		.bottom_layer, .bottom_layer_inner {
			background: none;
			font-family: Arial;
		}
		
		.ftl_message {
			display: none;
		}
		
		.quick_links_selection form button {
			margin-top: 0;
		}
		.page_contents {
			float: left;
			margin-top: 20px;
			line-height:166.667%;
		}
		.lhn_menu_l1_item_selected .lhn_menu_l1_title {
			background: #0097AC;
		}
		.chat_roundbox {
			border: 0;
		}
		</style>
	</head>
	<body>
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
		
		<script type="text/javascript" src="//www.optus.com.au/opfiles/OnePortal/lib/js_min/shared.js"> </script>
		<!---<script type="text/javascript" src="http://indra-dev.optus.com.au/mcas/portal/OnePortal/frontend/trunk/vault/onePortal/opfiles/OnePortal/lib/js_min/shared.js"> </script>--->
		
		<script type="text/javascript">/*<![CDATA[*/
			
			// Manually remove chat_roundbox
			$(document).ready(function(){
				$('div').remove('.chat_roundbox');
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
		
    <!-- HEADER STARTS -->
		
		<script type="text/javascript" src="https://smb.optus.com.au/opfiles/cc/static/assets/common/js/globalHeader.js"> </script>
		<script type="text/javascript" src="https://smb.optus.com.au/opfiles/OnePortal/lib/js/integrators/controller.help_support.js"> </script>
				
		<rn:widget path="utils/Templates/Header" />
		
		<!-- HEADER ENDS -->
		
		
		<? 
			$base_url = $_SERVER["HTTP_HOST"];
			
			if ($base_url == "optus.custhelp.com")
			{
				$base_url = "http://www.optus.com.au/home/";
			} else {
				$base_url = "../";
			}
		?>
		
		<div class="middle_layer clearfix">
			<div class="middle_layer_inner clearfix">
			<div class="content_section">
				<noscript>
			
			
			
			
				<span class="ftl_message ftl_error ftl_message_L0">							Your web browser does not support JavaScript or this feature has been disabled. <br/>
								Please enable Javascript to use this website. <br/>
	</span>
			
		
						</noscript>
			
				<div class="section_12 section clearfix">
				
				<div class="col_12 col">
				<!--<div class="column_content">-->
				<div class="lhn">
					<a name="lhn_nav"></a>
					<ul class="lhn_menu lhn_menu_l1 plain_list">
						<li class="lhn_menu_l1_item lhn_menu_l1_item_selected">
							<div class="lhn_menu_l1_title">Help &amp; Support</div>
							<ul class="lhn_menu_l2 plain_list">
								<li class="lhn_menu_l2_item">
									<a href="http://www.optus.com.au/home/help-support/welcome_to_optus"><span class="lhn_menu_arrow">&nbsp;</span>Welcome to Optus </a>
								</li>
								<li class="lhn_menu_l2_item">
									<a href="http://community.optus.com.au">My Optus Community</a>
								</li>
								<li class="lhn_menu_l2_item">
									<a href="https://devicehelp.optus.com.au">Mobile Device Help </a>
								</li>
								<li class="lhn_menu_l2_item <?if ($section == "Prepaid Mobile") echo "selected"?>">
									<a href="/app/product/list/p/766">Prepaid Mobile </a>
								</li>
								<li class="lhn_menu_l2_item <?if ($section == "Postpaid Mobile") echo "selected"?>">
									<a href="/app/product/list/p/773">Postpaid Mobile </a>
								</li>
								<li class="lhn_menu_l2_item <?if ($section == "DSL Broadband") echo "selected"?>">
									<a href="/app/product/list/p/781">DSL Broadband </a>
								</li>
								<li class="lhn_menu_l2_item <?if ($section == "NBN") echo "selected"?>">
									<a href="https://www.optus.com.au/shop/broadband/nbn/plans">NBN </a>
								</li>
								<li class="lhn_menu_l2_item <?if ($section == "Cable Broadband") echo "selected"?>">
									<a href="/app/product/list/p/782">Cable Broadband </a>
								</li>                  
								<li class="lhn_menu_l2_item <?if ($section == "Prepaid Mobile Broadband") echo "selected"?>">
									<a href="/app/product/list/p/784">Prepaid Mobile Broadband </a>
								</li>                  
								<li class="lhn_menu_l2_item <?if ($section == "Postpaid Mobile Broadband") echo "selected"?>">
									<a href="/app/product/list/p/783">Postpaid Mobile Broadband </a>
								</li>
								<li class="lhn_menu_l2_item <?if ($section == "Home Phone") echo "selected"?>">
									<a href="/app/product/list/p/780">Home Phone </a>
								</li>
								<li class="lhn_menu_l2_item <?if ($section == "Digital TV") echo "selected"?>">
									<a href="/app/product/list/p/785">Optus TV feat. Foxtel</a>
								</li>
								<li class="lhn_menu_l2_item <?if ($section == "Optus TV with Fetch") echo "selected"?>">
									<a href="/app/product/list/p/901">Optus TV with Fetch</a>
								</li>
								<li class="lhn_menu_l2_item <?if ($section == "Accounts & Billing") echo "selected"?>">
									<a href="/app/answers/list/kw/accounts%20and%20billing/search/1">Accounts &amp; Billing </a>
								</li>
							</ul>
						</li>
					</ul>
						
					<br />
					<rn:widget path="custom/banner" />
					<br />
					
					<div id="chat-consumer-service-custhelp"></div>		
				</div>

				<div class="page_contents">
          <div id="rn_PageTitle" class="rn_Home">
						<h1>Search Help &amp; Support</h1>
              <rn:condition is_spider="false">
                  <div id="rn_SearchControls">
                    <div class="search_applet_back_left"></div>
                      <h1 class="rn_ScreenReaderOnly">#rn:msg:SEARCH_CMD#</h1>
                      <form method="post" action="" onsubmit="return false" >
                          <div class="rn_SearchInput">
                              <!-- <rn:widget path="search/AdvancedSearchDialog" report_page_url="/app/answers/list" report_id="176"/> -->
                              
                              <p>Type in a keyword for the fastest way to get support through FAQs, How-to Guides and more.</p>
                              <div class="rn_SearchInput_element_container">
                                <div class="search_input_container_tile">
                                  <rn:widget path="search/KeywordText2" label_text="#rn:msg:FIND_THE_ANSWER_TO_YOUR_QUESTION_CMD#" initial_focus="true" report_id="101503"/>
                                  <div class="rn_AdvancedFilter rn_AdvancedSubWidget"><rn:widget path="search/ProductCategorySearchFilter" label_nothing_selected="All Support" filter_type="products"/></div>
                                  
                                  <div class="search_input_container_right_back"></div>
                                </div>
                              </div>
                              <rn:widget path="search/SearchButton2" report_page_url="/app/answers/list" report_id="101503"/>
                              
                          </div>
                      </form>
                      <div class="search_applet_back_right"></div>
                  </div>
              </rn:condition>
          </div>  

<!--  *************** Right now content ************** -->				
          <div class="main_page_contents">
							<rn:page_content/>
          </div>  
          <div class="main_page_rhs">
          
            <rn:widget path="custom/alert" a_id="1" />
                
            <div class="light_back_box" id="rn_self_service">
              <div class="light_back_header">
                <div class="back_left"></div>
                <img alt="Self Service" src="images/optus/self_service_icon.png" />
                <h3>Self Service</h3>
                <div class="back_right"></div>
              </div>
              <div class="light_content">
                <ul>
                  <li><a href="http://www.optus.com.au/paymybill">Pay a bill</a></li>
                  <li><a href="http://www.optus.com.au/activate">Activate my Prepaid mobile</a></li>
                  <li><a href="http://www.optus.com.au/login">Login to My Account</a></li>
                </ul>
              </div>
              <div class="light_back_footer"></div>
            </div>             
			
            <div class="light_back_box" id="rn_top_faq">
              <div class="light_back_header_full">
                <div class="back_left_full"></div>
                  <?
                  if (substr($_ENV["REQUEST_URI"], 0, 20) == "/app/answers/detail/")
                  {
                    ?>
                      <h3>Related FAQs</h3>
                    <?
                  } else {
                    ?>
                    <h3>Top FAQs</h3>
                    <?
                  };
                  ?>
                <div class="back_right_full"></div>
              </div>
              <div class="light_content_full">
                
                
                  <?
                  if (substr($_ENV["REQUEST_URI"], 0, 20) == "/app/answers/detail/")
                  {
                    ?>
                      <rn:widget path="custom/knowledgebase/RelatedAnswers2" limit="5"/>
                    <?
                  } else {
                    ?>
                    <rn:widget path="reports/Multiline2" report_id="162" per_page="5"/>
                    <?
                  };
                  ?>                
                
                
              </div>
              <div class="light_back_footer"></div>
            </div>  
            <div class="light_back_box" id="rn_twitter">
              <div class="light_back_header">
                <div class="back_left"></div>
                <img alt="Need Help?" src="images/optus/twitter_icon.png" />
                <h3>Need Help?</h3>
                <div class="back_right"></div>
              </div>
              <div class="light_content">
								<p>
									<a href="http://www.twitter.com/Optus" target="_new" rel="nofollow">Ask us on Twitter<br />follow @optus</a>
								</p>
              </div>
              <div class="light_back_footer"></div>
            </div>
			
          </div> 
<!--  ************************************************ -->				
				</div>
				<!--</div>-->
				</div>
				</div>
				</div>
        
			</div>
		</div>
		
		<!-- FOOTER STARTS -->
		
		<rn:widget path="utils/Templates/Footer" />
		
		<!-- FOOTER ENDS -->
		
		<script type="text/javascript">
			<!--
					if (window.includeScript && window.includeScript.bodyFooterReached) {
						includeScript.bodyFooterReached();
					}
			-->
				</script>
		<!-- Footer code snippet -->		
		<script src="//personal.optus.com.au/web/ShowBinary/SCSRepository/assets/wowpx/247wowpx.js" type="text/javascript"></script>
	</body></html>
<?php
}
?>
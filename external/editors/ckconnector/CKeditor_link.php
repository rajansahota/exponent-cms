<?PHP
	define("SCRIPT_EXP_RELATIVE","external/editors/ckconnector/");
	define("SCRIPT_FILENAME","CKeditor_link.php");
	
	require_once('../../../exponent.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Insert/Modify Link</title>

		<script type="text/javascript" src="<?PHP echo PATH_RELATIVE ?>exponent.js.php"></script>
		<script type="text/javascript" src="popup.js"></script>
		<script type="text/javascript" src="<?PHP echo PATH_RELATIVE . 'external/editors/ckconnector/lang/' . exponent_lang_convertLangCode(LANG) . '.js'?>"></script>
  		<script type="text/javascript">
		/* <![CDATA[ */
			I18N = eXp.I18N;
			
			function i18n(str) {
  				return (I18N[str] || str);
			};
			
			function getUrlParam(paramName) {
				var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
				var match = window.location.search.match(reParam) ;

				return (match && match.length > 1) ? match[1] : '' ;
			}
			
			function onPageSelect(section) {
				
				// CKeditor integration
				var funcNum = getUrlParam('CKEditorFuncNum');
				var fileUrl = section;
				window.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl);
		
				window.close();
				return false;
			};

			function onOK() {
				
				// CKeditor integration
				var funcNum = getUrlParam('CKEditorFuncNum');
				var fileUrl = document.getElementById("f_href").value;
				window.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl);

				window.close();
				return false;
			};

			function onCancel() {
				window.close();
				return false;
			};



			function openSectionLinker() {
				window.open("../../../modules/navigationmodule/nav.php?linkbase="+escape("../../external/editors/ckconnector/section_linked.php?dummy"),"sectionlinker","toolbar=no,title=no,width=250,height=480,scrollbars=yes");
			}

			function openContentLinker() {
				window.open("../../../content_selector.php?dest="+escape("external/editors/ckconnector/content_linked.php?dummy")+"&vview=_linkPicker&vmod=containermodule&showmodules=all","contentlinker","toolbar=no,title=no,width=640,height=480,scrollbars=yes");
//				window.open("../../../content_selector.php?dest="+escape("external/editors/ckconnector/content_linked.php?dummy")+"&vview=_sourcePicker&vmod=containermodule&showmodules=all","contentlinker","toolbar=no,title=no,width=640,height=480,scrollbars=yes");
			}
		/* ]]> */
		</script>

		<style type="text/css">
		/* <![CDATA[ */
			html, body {
  				background: ButtonFace;
				color: ButtonText;
				font: 11px Tahoma,Verdana,sans-serif;
				margin: 0px;
				padding: 0px;
			}
			body {
				padding: 5px;
			}
			table {
				font: 11px Tahoma,Verdana,sans-serif;
			}
			select, input, button {
				font: 11px Tahoma,Verdana,sans-serif;
			}
			button {
				width: 70px;
			}
			table .label {
				text-align: right;
				font-weight: normal;
				vertical-align: top;
				width: 12em;
			}

			.title {
				background: #ddf;
				color: #000;
				font-weight: bold;
				font-size: 120%;
				padding: 3px 10px;
				margin-bottom: 10px;
				border-bottom: 1px
				solid black;
				letter-spacing: 2px;
			}

			a {
				text-decoration: none;
				color: rgb(97,115,132);
				font-weight: bold;
			}

			#buttons {
				margin-top: 1em;
/*				border-top: 1px */
				solid #999;
				padding: 2px;
				text-align: right;
			}
		/* ]]> */
		</style>

	</head>

	<body onload="__dlg_translate(eXp._TR);">
		<div class="title">Insert/Modify Link</div>

		<table border="0" style="width: 100%;">
			<tbody>
				<tr>
					<td colspan="2"><hr size="1" />
						<a class="header">Select a Page, or Content</a>
					</td>
				</tr>
				<tr>
					<td class="label"><br />Select a Page below</td>
					<td align="right">
						<a href="#" onclick="openContentLinker(); return false;">Link to Content</a>
						<input id="f_href" type="hidden"/>
						<input id="f_extern" checked="checked" type="hidden"/>
						<input id="f_title" type="hidden"/>
						<div id="buttons">
							<button type="button" name="ok" onclick="return onOK();">OK</button>
							<button type="button" name="cancel" onclick="return onCancel();">Cancel</button>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		
<?PHP
include(BASE.'modules/navigationmodule/nav.php');
?>		
	</body>
</html>
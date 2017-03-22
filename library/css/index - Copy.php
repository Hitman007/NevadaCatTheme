<?php
	include("includes/constant.php");
        if(isset($_GET['popup']) && $_GET['popup'] != ""){
            $_SESSION['open_popup'] = $_GET['popup'];
            header("location:".HTTP_ROOT);
        }
	include(TEMPLATE_PATH."head.php");
?>
<script type="text/javascript">
    var HTTP_ROOT = "<?php echo HTTP_ROOT; ?>";
    var template_url = "<?php echo AJAX_TEMPLATE_PATH; ?>";
    var ajaxUrl =  "<?php echo HTTP_ROOT.'ajax.php' ?>";
    var ajax_main_path = "<?php echo AJAX_MAIN_PATH ?>";
    var includes_path = "<?php echo INCLUDES_PATH ?>";
	var setp_url = "<?php echo AJAX_SETP_PATH; ?>";
    var images_path = "<?php echo IMAGE_PATH ?>";
    var autosave_time = "<?php echo AUTOSAVE_SEC ?>";
    var ajaxFinished = '1';
    var autoSaveFinished = '1';
    var typingTimer;                //timer identifier
    var doneTypingInterval = 10000;  //time in ms, 5 second for example
    var iswritable = 1;
    var need_saving = 0;
    var tab_page_count = <?php echo isset($_SESSION['tab_page_count']) ? $_SESSION['tab_page_count'] : 0; ?>;
    var paging_setting = {callback: pageselectCallback,items_per_page:"1", num_display_entries:"4", num_edge_entries:"2",next_text:"Next »",prev_text:"« Prev"};
    var popup_open ="";
	var last_tab_id = 0;
	var cr_tab_id = <?php echo $_SESSION['tab_id']?>;
	var cr_tab_page = 0;
	var last_tab_page = 0;
	var temp_pg_index = 0;
</script>
  <body onLoad="def()">
   <?php        include(TEMPLATE_PATH."findit.php");
		include(TEMPLATE_PATH."notfy-r.php");
                include(TEMPLATE_PATH."notfy-g.php");
				
 ?> <!--just an example of a error notification placement, change notfy-r to notfy-g to see success notification-->
   <div class="inform cntr btmshdw pie hide">
   </div>
<script type="application/javascript" language="javascript">
   	
			
   </script>
  <div id="overlay" class="overlay"></div>
      <div id="boxpopup" class="box rad pie hide">
		<a onClick="closepop('boxpopup');" class="boxclose"></a>
      	<div id="dynamic_content">
        </div>
      </div>
  <input type="hidden" id="subs_plan" name="sub_plan" >
  <input type="hidden" id="ren_plan" name="ren_plan" >
         <div class="mainlinks btmshdw pie">
      <ul class="links">
        <li class="left">
          <a class="blu top_links" href="<?php if(isset($_SESSION['userId'])  && !isset($_SESSION['subs_expired'])) echo 'upgrd.php'; else echo '#';?>"><span class="i">
                    <?php if(isset($_SESSION['subscription'])){
                        echo $_SESSION['subscription'];
                    }
                        else { echo "Free for me";}
?>
              </span></a> <!--this needs to reflect users current subscription tier.-->
        </li>
		<li class="leftnbnm fnt130 bold">
		"computer science" <span class="fnt80 i">is writable</span><!--add dynamic notebook name here and edit status-->
		</li>
      <?php 
	  	include_once(TEMPLATE_PATH."top_links.php"); 
	  ?>
      </ul>
    </div>
    <?php

		if(!isset($_SESSION["logoHide"])){
	?>
        <div id="logohd">
          <a class="logo" href="#" title="hide me">notebasket logo</a>
        </div>
    <?php
	}
	?>
  <div id="pgnum">
    <div class="pagination delpg">
           <a class="inset1" id="share_disable" title=
        "WARNING! This will delete your current page, you cannot undo!"
        name="share_disable"><span class="rd" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onclick=
            \"delpagepopup()\"";?>>del</span></a>
    </div>
      <div id="Pagination" class="pagination pagin">
        <span class="disabled">« prev</span> <span class="disabled"
        data-page="1">1</span><a class="inset1" href="#2"
        data-page="2">2</a> ... <a class="inset1" href=
        "#3">1006</a><a class="inset1" href="#4">1007</a><a class=
        "inset1" href="#5">1008</a> ... <a class="inset1" href=
        "#1439">1439</a><a class="inset1" href=
        "#1440">1440</a><a class="inset1 next" href="#2">next »</a>
      </div>
    <div class="pagination">
           <a class="inset1 blk2 <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo 'addPage';?>" title=
        "add new page to this tab">add</a>
    </div>
  </div>    
	<div id="cntrvh">
    <?php
		if(isset($_SESSION["userId"]) && !isset($_SESSION['subs_expired'])){ 
	?>
     <div>
<!--         <input type="text" name="prevCount" value="1">-->
     <input type="hidden" name="nbId" value="25">
     <input type="hidden" name="tabId" value="tabs1">
<!--     <input type="text" name="nbTot" value="3">-->
     <input type="hidden" name="pageId" value="0">
     	<span id="editor_view">
        	<?php include(TEMPLATE_PATH."editor.php"); ?>
        </span>
      </div>
      <?php
	   }
	   
       else {
	
       ?>
   			<?php include(TEMPLATE_PATH."editor_default.php"); ?>
        
        <?php
		}
		?>
      </div>
    </div>
  
  
    <div id="notebooks" class="rad shdw pie scrl">
      <div class="ttl">
        notebooks
      </div>
    <div id="notebook">
	  <div id="adddel">
        <div>
          <ul class="flt-r">
            <li>
              <a class="addnb rad2 shdw2 inset2 pie top_links" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo 'onclick="addntbkpopup()"';?> title="add notebook">add</a>
            </li>
          </ul>
        </div>
        <div>
          <ul class="flt-l">
            <li>
              <a class="delnb rad2 shdw2 inset2 pie" title=
              "WARNING! This will delete your current notebook, you cannot undo!">
              <span class="rd" id="<?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo 'delete_notebook';?>">del</span></a>
            </li>
          </ul>
        </div>
      </div>
	</div>
		 <?php

		if(isset($_SESSION["userId"]) && !isset($_SESSION['subs_expired']))
		{
                    
		?>
                        
			<script type="application/javascript">	
                var data='<?php echo $_SESSION["userId"]; ?>';
            		loadNotebooks(data);
                  
            </script>
     	<?php
			}
		?>

          <div id="notebook_menu">
						<div class="nbshrdboxgry rad pie">
                                    <div class="moveup">
									<div id="" class="shrd2me">shared 2 me</div>
                        <div class="cover cvr20">
                            <div class="spiral-sm">
                            &nbsp;
                            </div>
                        <div class="nb nb1 nbbcshrd"> <!--default non-shared ntbk class is .nbbc  / class .nbbcshrd is shared-->
                            <a class=""  title="biology - shared 2 me by: myfriend@gmail.com">notebook name</a>
                            </div>
                                    <ul class="ntbknm">
                                    <li>biology</li> <!--set character count to 10 including ellipises-->
                                    </ul>
                        </div>
						</div>
						</div>
						<div class="spacer1">&nbsp;</div>
                        <div class="cover cvr20">
                            <div class="spiral-sm">
                            &nbsp;
                            </div>
                        <div class="nb nb3 nbbc">
                            <a class="" title="computer science">notebook name</a>
                        </div>
                                    <ul class="ntbknm">
                                    <li>computer...</li> <!--set character count to 10 including ellipises-->
                                    </ul>
                        </div>
                        <div class="cover cvr20">
                            <div class="spiral-sm">
                            &nbsp;
                            </div>
                        <div class="nbdis nbbcdis">
                            &nbsp;
                        </div>
                        </div>
                        <div class="cover cvr20">
                            <div class="spiral-sm">
                            &nbsp;
                            </div>
                        <div class="nbdis nbbcdis">
                            &nbsp;
                        </div>
                        </div>
                        <div class="cover cvr20">
                            <div class="spiral-sm">
                            &nbsp;
                            </div>
                        <div class="nbdis nbbcdis">
                            &nbsp;
                        </div>
                        </div>	
               </div>
          </div>
    </div>
 <div id="foot">
      <div class="footer">
        <p>
          The Notebasket.com logo and all images, service &amp;
          dress marks, favicon and backgrounds are our exclusive
          trademarks<br />
          Copyright &copy; <span id="year">2012</span> Notebasket.com,
          All Rights Reserved. Notebasket.com is a channel of
          <a target="new" href=
          "http://www.shopfin.com">Shopfin.com</a>, LLC
        </p>
      </div>
    </div>    <div id="tools" class="">
     <div id="tools1" class="rad shdw pie scrl">
      <div class="ttl">
        tools
      </div>
      <div class="t1">
        <a class="inset" title="trash basket" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onclick=\"openpop_url('trsh.php')\"";?> ><span class=
        "trash">trash</span></a>
      </div>
      <div class="t1">
        <a class="inset" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onclick=\"findit()\"";?> title="find in document"><span class=
        "find">find</span></a>
      </div>
      <div class="t1">
        <a class="inset <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "savePage";?>" title="save"><span class=
        "save">save</span></a>
      </div>
      <div class="t1">
        <a class="inset" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onClick=\"window.print();\"";?> title="print"><span class=
        "print">print</span></a>
      </div>
      <div class="t1">
        <a class="inset" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onClick=\"testing()\"";?> title="cut"><span class=
        "cut">cut</span></a>
      </div>
      <div class="t1">
        <a class="inset" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onClick=\"fontEdit('copy')\"";?> title="copy"><span class=
        "copy">copy</span></a>
      </div>
      <div class="t1">
        <a class="inset" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onClick=\"fontEdit('paste')\"";?> title="paste"><span class=
        "paste">paste</span></a>
      </div>
      <div class="t1">
        <a class="inset" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onclick=\"show_info()\"";?> title="available notebooks, tabs and pages remaining"><span class=
        "info">info</span></a>
      </div>
      <div class="t1">
        <a class="inset" onClick="" title="zoom in"><span class="zin">zoom in</span></a>
      </div>
	 </div>
    <div id="tools2" class="rad shdw pie scrl">
      <div class="t1">
        <a class="inset" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onClick=\"toggle_fontsize();\"";?> title="text size">t<span class=
		"fnt75">t</span></a><input type ="hidden" id="text_size" value="4"/>
    </div>
	<div class="hvrcolor">
      <div id="color">
        <ul>
          <li>
            <a class="color-blk" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onClick=\"fontEdit('ForeColor','black');\"";?>  title="black text" href="javascript:void(0);"></a>
          </li>
          <li>
            <a class="color-red" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onClick=\"fontEdit('ForeColor','red');\"";?> title="red text" href="javascript:void(0);"></a>
          </li>
          <li>
            <a class="color-blu" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onClick=\"fontEdit('ForeColor','blue');\"";?> title="blue text" href="javascript:void(0);"></a>
          </li>
          <li>
            <a class="color-grn" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onClick=\"fontEdit('ForeColor','#00FF00');\"";?> title="green text" href="javascript:void(0);"></a>
          </li>
        </ul>
      </div>
    </div>
	<div class="t1">
        <a class="inset addclass" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onClick=\"fontEdit('bold')\"";?>  title="bold"><span class=
        "bld">b</span></a>
      </div>
      <div class="t1">
        <a class="inset" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onClick=\"fontEdit('italic')\"";?> title="italic"><span class=
        "i">i</span></a>
      </div>
      <div class="t1">
        <a class="inset" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onClick=\"fontEdit('underline')\"";?> title="underline"><span class=
        "uln" >u</span></a>
      </div>
      <div class="t1">
        <a class="inset" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onClick=\"fontEdit('insertunorderedlist')\"";?> title="bullets">&bull;-</a>
      </div>
      <div class="t1">
        <a class="inset" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onClick=\"fontEdit('insertorderedlist')\"";?> title="numbering">1-</a>
      </div>
      <div class="t1">
        <a class="inset" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onClick=\"toggle_hilite();\"";?>  title="highlight"><span class=
        "hlight">h</span></a>
          <input type ="hidden" id="hlight" value="yellow"/>
      </div>
      <div class="t1">
        <a class="inset" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onClick=\"fontEdit('justifyleft')\"";?>  title="left">|--</a>
      </div>
      <div class="t1">
        <a class="inset" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onClick=\"fontEdit('justifyright')\"";?> title="right">--|</a>
      </div>
      <div class="t1">
        <a class="inset" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onClick=\"fontEdit('justifycenter')\"";?> title="center">|-|</a>
      </div>
      <div class="t1">
        <a class="inset" <?php if(isset($_SESSION['userId']) && !isset($_SESSION['subs_expired'])) echo "onClick=\"fontEdit('justifyfull')\"";?> title="justify">---</a>
      </div>
     </div>
	</div>
    <?php include (TEMPLATE_PATH.'footer.php'); ?>
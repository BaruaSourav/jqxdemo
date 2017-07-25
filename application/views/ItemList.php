
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Items' List</title>
    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>  

    <script type="text/javascript"  src="<?php echo base_url('scripts/jquery-1.11.1.min.js') ?>"></script>
    <script type="text/javascript"  src="<?php echo base_url('js/bootstrap.min.js') ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('jqwidgets/styles/jqx.base.css')?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url('jqwidgets/styles/jqx.metro.css')?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url('jqwidgets/styles/jqx.energyblue.css')?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url('css/bootstrap.min.css')?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url('css/animate.css')?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url('css/hover-min.css')?>" type="text/css" />
    <!-- <link rel="stylesheet" href="<?php echo base_url('styles/global.css')?>" type="text/css" /> -->
    <link rel="shortcut icon" href="<?php echo base_url('images/mmtvlogoicon')?>" />
    <script type="text/javascript"  src="<?php echo base_url('jqwidgets/jqxcore.js')?>"></script>
<script type="text/javascript"  src="<?php echo base_url('jqwidgets/jqxdata.js')?>" /></script>
<script type="text/javascript"  src="<?php echo base_url('jqwidgets/jqxbuttons.js')?>" /></script>
<script type="text/javascript"  src="<?php echo base_url('jqwidgets/jqxscrollbar.js')?>" /></script>
<script type="text/javascript"  src="<?php echo base_url('jqwidgets/jqxmenu.js')?>" /></script>
<script type="text/javascript"  src="<?php echo base_url('jqwidgets/jqxcheckbox.js')?>" /></script>
<script type="text/javascript"  src="<?php echo base_url('jqwidgets/jqxlistbox.js')?>" /></script>
<script type="text/javascript"  src="<?php echo base_url('jqwidgets/jqxdropdownlist.js')?>" /></script>
<script type="text/javascript"  src="<?php echo base_url('jqwidgets/jqxgrid.js')?>" /></script>
<script type="text/javascript"  src="<?php echo base_url('jqwidgets/jqxgrid.sort.js')?>" /></script>
<script type="text/javascript"  src="<?php echo base_url('jqwidgets/jqxgrid.pager.js')?>" /></script>
<script type="text/javascript"  src="<?php echo base_url('jqwidgets/jqxgrid.selection.js')?>" /></script>
<script type="text/javascript"  src="<?php echo base_url('jqwidgets/jqxgrid.edit.js')?>" /></script>
<script type="text/javascript"  src="<?php echo base_url('jqwidgets/jqxwindow.js')?>" /></script>
<script type="text/javascript"  src="<?php echo base_url('jqwidgets/jqxinput.js')?>" /></script>
<script type="text/javascript"  src="<?php echo base_url('jqwidgets/jqxnotification.js')?>" /></script>
<script type="text/javascript"  src="<?php echo base_url('jqwidgets/jqxdata.export.js')?>" /></script>
<script type="text/javascript"  src="<?php echo base_url('jqwidgets/jqxgrid.export.js')?>" /></script>

<script>
$(document).ready(function()
{
    $("#reportxls").click(function() {
                $("#itemGrid").jqxGrid('exportdata', 'xls', 'ItemReport');
                });


   $("#topMenu").jqxMenu({ width: '100%', height: '35px'});
   //dropdown for brand data source returning json
   var brandSource ={
        datatype:"json",
        mtype:"get",
        datafields:
            [
                {name:'brand_id'},
                {name:'name'}

            ],
        url:'<?php echo site_url("Brands/getBrandsForDD") ?>',
        id:'brand_id'


   };

   var modelSource ={
        datatype:"json",
        mtype:"get",
        datafields:
            [
                {name:'model_id'},
                {name:'name'}

            ],
        url:'<?php echo site_url("Models/getModelsForDD") ?>',
        id:'model_id'


   };





   //grid data source
       var source ={
        datatype: "json",
        mtype : "post", 
        datafields: 
        [
            {name: 'item_id'},
            {name: 'model_id'},
            {name: 'brand_id'},
            {name:'name'},
            {name:'date_added'},
            {name:'brandName'},
            {name:'modelName'}

        ],
        url: '<?php echo site_url("Items/loadData")?>',
        id:'item_id',

        updaterow: 
            function (rowid, rowdata, commit) {
                var url = '<?php echo site_url('Items/updateRow/');?>' + rowid;
                console.log(rowdata);
                console.log(url);
                $.ajax({
                    data:rowdata,
                    contenttype:"application/json;charset=utf-8",
                    url:url,
                    type:'post',
                    success:
                    function(){
                        $("#itemGrid").jqxGrid('updatebounddata', 'cells');

                        commit(true);
                    },

                    error:
                    function(){

                        commit(false);
                        alert("Server Error Occured!!");

                    }


                });

        },
    deleterow:
        function (rowid, commit) {
           var url = '<?php echo site_url('Items/deleteItem/');?>' + rowid;
                             //console.log("In deleterow="+ url);
                             $.ajax({

                                url:url,
                                type:'post',
                                success:
                                function(){

                                    commit(true);
                                },

                                error:
                                function(){

                                    commit(false);
                                    alert("Server Error Occured!!");

                                }


                            });

                         },
        addrow:
                     function(rowid,rowdata,position,commit){
                            //console.log("addrow in jqxgrid initiated");
                            commit(true);

                            ////////////////////////////////////////////////////////////
                            var url = '<?php echo site_url('Items/addItem/');?>';
                            console.log("In addrow source response="+ url);
                            $.ajax({
                                data:rowdata,
                                contenttype:"application/json;charset=utf-8",
                                url:url,
                                type:'post',
                                success:
                                function(){
                                    $("#notifsuccess").text(rowdata.name);   
                                    $("#itemGrid").jqxGrid('updatebounddata', 'cells');
                                    $("#SuccessNotification").jqxNotification("open");
                                    $("#popupWindowadd").jqxWindow('hide');

                                    commit(true);
                                },

                                error:
                                function(){

                                    commit(false);
                                    alert("Server Error Occured!!");

                                }


                            });

                        }

                    };

            ///////////////////////////////////////////////////////////////////
            // Data Adapater for the Grid from the source variable
            var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function (data) { },
                loadError: function (xhr, status, error) { }    
            });
            /////////////////////////////////////////////////////////////////////
            //Data Adapter for brand dropdown

            var brandDataAdapter = new $.jqx.dataAdapter (brandSource, {
                loadComplete: function (data) { },
                loadError: function (xhr, status, error) { }    
            });
            ////////////////////////////////////////////////////////////////////
            //Data Adapter for brand dropdown

            var modelDataAdapter = new $.jqx.dataAdapter (modelSource, {
                loadComplete: function (data) { },
                loadError: function (xhr, status, error) { }    
            });
            ////////////////////////////////////////////////////////////////////


            //brand dropdownList initialization for edit
            $("#brandDD").jqxDropDownList({
                    source: brandDataAdapter, displayMember: "name", 
                    valueMember: "brand_id", width: "100%", height: 25,
                    promptText:"Select Brand"
                });
            //model dropdownList initialization for edit
            $("#modelDD").jqxDropDownList({
                    source: null, 
                    displayMember: "name", 
                    valueMember: "model_id", 
                    width: "100%", height: 25,
                    placeHolder:"Select A model",
                    disabled:true
                });

            $("#brandDD").bind('select', function (event) {
                    //debugger;
                    if (event.args) {
                            //console.log("in binding");
                            $("#modelDD").jqxDropDownList({disabled: false});
                            var value = event.args.item.value;
                            console.log(value);
                            modelSource.data = {brand_id: value };
                            modelDataAdapter  = new $.jqx.dataAdapter(modelSource);
                            $("#modelDD").jqxDropDownList({ source: modelDataAdapter });
                    }
                    });





            //brand dropdownList initialization for adding
            $("#brandDDadd").jqxDropDownList({
                    source: brandDataAdapter, 
                    displayMember: "name", 
                    valueMember: "brand_id", 
                    width: "100%", height: 25,
                    placeHolder:"Select A Brand"
                });

            $("#modelDDadd").jqxDropDownList({
                    source: modelDataAdapter, displayMember: "name", 
                    valueMember: "model_id",
                    width: "100%", 
                    height: 25,
                    placeHolder:"Select A Model"
                });

            $("#brandDDadd").bind('select', function (event) {
                    //debugger;
                    if (event.args) {
                            //console.log("in binding");
                            $("#modelDDadd").jqxDropDownList({disabled: false});
                            var value = event.args.item.value;
                            console.log(value);
                            modelSource.data = {brand_id: value };
                            modelDataAdapter  = new $.jqx.dataAdapter(modelSource);
                            $("#modelDDadd").jqxDropDownList({ source: modelDataAdapter });
                    }
                    });




            //initializing the edit input fields' properties
            $("#itemName").jqxInput({ theme: 'metro' });
            $("#itemName").width(150);
            $("#itemName").height(23);
            ////initializing the edit input fields' properties
            $("#itemNameadd").jqxInput({ theme: 'metro' });
            $("#itemNameadd").width(150);
            $("#itemNameadd").height(23);


            var editrow = -1;
            var dataRecord=null;
            var deleterow = -1;
            //Edit image renderer
            var EditImageRenderer = function (row, datafield, value) {

                return '<img class="hvr-pulse-grow" style="margin-left:32%;" height="30px" width="30px" src="<?php echo base_url('images/edit.png'); ?>"  />';
            };
            //Delete image renderer
            var DeleteImageRenderer = function (row, datafield, value) {

                return '<img class="hvr-pulse-grow" style="margin-left:32%;" height="30px" width="30px" src="<?php echo base_url('images/delete.png'); ?>"  />';
            };


            $('#itemGrid').jqxGrid(
            {
                source:dataAdapter,
                width:'100%',
                theme:'energyblue',
                sortable:true,
                pageable:'true',
                height:400,


                columns:
                [

                {text:'Name',datafield:'name',width:'20%',sortable:true},
                {text:'Brand',datafield:'brandName',width:'20%',sortable:true},
                {text:'Model',datafield:'modelName',width:'20%',sortable:true},
                {text:'Adding Date',datafield:'date_added',width:'20%',sortable:true},
                // {datafield:'brand_id',hidden:true},
                {text:'Edit',
                sortable:false,
                menu:false,
                width:'10%',
                columntype:'number',
                cellsrenderer:EditImageRenderer

            },
            {
                text:'Delete',
                sortable:false,
                menu:false,
                columntype:'number',
                width:'10%',
                cellsrenderer:DeleteImageRenderer

            }

            ]
        }
        );

            // Cell click responsers

            $("#itemGrid").on("cellclick", function (event) {
                var column = event.args.column;
                var rowindex = event.args.rowindex;
                var columnindex = event.args.columnindex;
                            //console.log(columnindex);

                            //edit coliumn response
                            if (columnindex == 4) { // if the column is edit column 
                                // open the popup window when the user clicks the button.
                                editrow = rowindex;
                                var offset = $("#itemGrid").offset();
                                $("#popupWindow").jqxWindow({ position: { x: parseInt(offset.left) + 650, y: parseInt(offset.top) + 60} });
                                // get the clicked row's data and initialize the input fields.
                                
                                dataRecord= $("#itemGrid").jqxGrid('getrowdata',editrow);
                                //console.log(dataRecord);
                                // initializing the input fields
                                $("#itemName").val(dataRecord.name);
                                $("#brandDD").val(dataRecord.brand_id);
                                $("#modelDD").val(dataRecord.model_id);
                                console.log(dataRecord.model_id);
                                console.log($("#modelDD").val());
                                //showing pop-up window
                                $("#popupWindow").jqxWindow('open');

                            }
                            else if(columnindex == 5) { // if the column is delete column 
                                // open the popup window when the user clicks the button.
                                deleterow = rowindex;
                                var offset = $("#itemGrid").offset();
                                $("#popupWindow").jqxWindow({ position: { x: parseInt(offset.left) + 650, y: parseInt(offset.top) + 60} });
                                // get the clicked row's data and initialize the input fields.
                                
                                dataRecord= $("#itemGrid").jqxGrid('getrowdata',deleterow);
                                console.log(dataRecord);
                                

                                // initializing the name field
                                $("#bn").text(dataRecord.name);
                                $("#brandDD").val(dataRecord.brand_id);
                                $("#brandDD").jqxDropDownList

                                //showing pop-up window

                                $("#popupWindowdel").jqxWindow('open');
                            }







                        });
            //initializing the edit pop up window

            $("#popupWindow").jqxWindow({
                theme:'metro',width: 280,resizable: false,  isModal: true, autoOpen: false,
                cancelButton: $("#Cancel"), modalOpacity: 0.01           
            });


            //delete pop up window initialization
            $("#popupWindowdel").jqxWindow({
                theme:'metro',width: 280, resizable: false,height:200, 
                isModal: true, autoOpen: false, cancelButton: $("#Canceldel"), modalOpacity: 0.01           
            });

            //add pop up window initialization
            $("#popupWindowadd").jqxWindow({
                theme:'metro',width: 400, resizable: false,height:160,
                isModal: true, autoOpen: false, 
                cancelButton: $("#Canceladd"), modalOpacity: 0.01           
            });

            //selecting the input element when edit window opens up
            $("#popupWindow").on('open', function () {
                $("#itemName").jqxInput('selectAll');
            });
             //selecting the input element when add window opens up
             $("#popupWindowadd").on('open', function () {
                $("#itemNameadd").text("");
                $("#itemName").focus();
            });
            //initializing the add button
           // $("#addbtn").jqxButton({ theme: 'metro' });

            //initializing the buttons of add pop-up
            $("#Add").jqxButton({ theme: 'metro' });
            $("#Canceladd").jqxButton({ theme: 'metro'});

            //initializing the buttons of edit pop-up
            $("#Cancel").jqxButton({ theme: 'metro' });
            $("#Save").jqxButton({ theme: 'metro'});

            //initializing the buttons of delete pop-up
            $("#Canceldel").jqxButton({ theme: 'metro' });
            $("#Delete").jqxButton({ theme: 'metro'});

            // updating the edited row when the user clicks the 'Save' button.
            $("#Save").click(function () {
                 dataRecord= $("#itemGrid").jqxGrid('getrowdata',editrow);


                if(($("#itemName").val() !="") && (editrow >= 0) && (dataRecord.model_id != $("#modelDD").val() ))
                    {

                            //getting all the rows
                            var allrows = $("#itemGrid").jqxGrid('getrows');
                            //console.log(allrows);
                            //comparing with the given value in textbox
                            allrows.forEach(function(row)
                            {
                                if(($("#itemName").val() == row.name) && ($("#itemName").val() != dataRecord.name))
                                {
                                    $("#notifbn").text(row.name);
                                    $("#DuplicateNotification").jqxNotification("open");
                                    exit;
                                    
                                }
                            });

                            var row = {
                                        name: $("#itemName").val(),
                                        model_id:$("#modelDD").val(),
                                        brand_id:$("#brandDD").val(),
                                        brandName:dataRecord.brandName
                                    };



                            var rowID = $('#itemGrid').jqxGrid('getrowid', editrow);
                            $('#itemGrid').jqxGrid('updaterow', rowID, row);
                            $("#popupWindow").jqxWindow('hide');
                            dataRecord =null;
                            

                        }
                        else 
                        {

                            $("#notifrequired").text('Model Name');   
                            $("#RequiredNotification").jqxNotification("open");



                        }


                // if (editrow >= 0) {

                //     var row = {
                //         name: $("#brandName").val(),
                //         noOfItems:dataRecord.noOfItems,
                //         brand_id:$("#brandDD").val(),
                //         brandName:dataRecord.brandName
                //     };

                //     var rowID = $('#itemGrid').jqxGrid('getrowid', editrow);
                //     $('#itemGrid').jqxGrid('updaterow', rowID, row);
                //     $("#popupWindow").jqxWindow('hide');
                //     dataRecord =null;
                // }
            });
            // Deleteing the row when the user clicks the 'Delete' button.
            $("#Delete").click(function () {

                if (deleterow>= 0) {
                    var rowID = $('#itemGrid').jqxGrid('getrowid', deleterow);
                    $('#itemGrid').jqxGrid('deleterow', rowID);
                    console.log(rowID);
                    $("#popupWindowdel").jqxWindow('hide');
                    dataRecord =null;
                }
            });

            // Add New Model Button click responses with an adding window
            $("#addbtn").click(function () {

                var x = $(window).width()/2 - 120;
                var y = $(window).height()/2 - 150;
                var windowScrollLeft = $(window).scrollLeft();
                var windowScrollTop = $(window).scrollTop();
                $("#popupWindowadd").jqxWindow(
                    { 
                        position: { 
                        x: x + windowScrollLeft,
                        y: y + windowScrollTop
                    } 
                    });

                $("#popupWindowadd").jqxWindow('open');

                $("#itemNameadd").val("");
                $("#brandDDadd").jqxDropDownList('selectedIndex',-1);
                $("#modelDDadd").jqxDropDownList('selectedIndex',-1);

                $("#itemNameadd").focus();


                
            });

            //All notification initialization

            //Duplicate notification message
            $("#DuplicateNotification").jqxNotification({
                width: 250, position: "bottom-right", opacity: 0.9,
                autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
            });

            //Success notification message
            $("#SuccessNotification").jqxNotification({
                width: 250, position: "bottom-right", opacity: 0.9,
                autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "success"
            });
            //duplicate notification message
            $("#RequiredNotification").jqxNotification({
                width: 250, position: "bottom-right", opacity: 0.9,
                autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "error"
            });
                          // Add Button click 
            $("#Add").click(function () {

                    if($("#itemNameadd").val() != "" && $("#brandDDadd").val!="")
                    {
                            //getting all the rows
                            var allrows = $("#itemGrid").jqxGrid('getrows');
                            //console.log(allrows);
                            //comparing with the given value in textbox
                            allrows.forEach(function(row)
                            {
                                if($("#itemNameadd").val() == row.name)
                                {
                                    $("#notifbn").text(row.name);
                                    $("#DuplicateNotification").jqxNotification("open");
                                    exit;
                                    
                                }
                            });

                            var newrow = {name:$("#itemNameadd").val(),
                                                model_id: $("#modelDDadd").val(),
                                                brand_id: $("#brandDDadd").val()
                                            };       
                            console.log('new row:'+ newrow); 
                            $('#itemGrid').jqxGrid('addrow',null,newrow,'top');
                            $("#popupWindowadd").jqxWindow('open');
                            

                        }
                        else 
                        {

                            if ($("#brandDDadd").val()=="") {
                                $("#notifrequired").text('Selecting a Brand');   
                                $("#RequiredNotification").jqxNotification("open");
                            };
                            if ($("#itemNameadd").val()=="") {
                                $("#notifrequired").text('Item Name');   
                                $("#RequiredNotification").jqxNotification("open");
                            };




                        }














                    });
        



    } ); // document ready ends here











</script>

</head>



<body>

    <!-- Menu on the top -->
     <div id='topMenu'>
        <ul>

            <li> 
                <a href="<?php echo site_url('Brands'); ?>">
                <img height="20px" width="20px" src="<?php echo base_url('images/cell.png') ?>"/>Show Brands' Information</a>
            </li>
            <li>
                 <a href="<?php echo site_url('Models'); ?>"> 
                    <img height="20px" width="20px" src="<?php echo base_url('images/brand.png') ?>"/> Show Models' Information
                </a>
            </li>
            <li>
                 <a href="<?php echo site_url('Items'); ?>" >
                    <img height="20px" width="20px" src="<?php echo base_url('images/item.png') ?>"/> Show Items' Information
                </a>
            </li>
            <li>
                 <span class="glyphicon glyphicon-print"></span> Download PDF 
                 <ul>
                    <li> <a href="<?php echo site_url('Brands/reportBrand'); ?>">Download Brand Report</a> </li>
                    <li> <a href="<?php echo site_url('Models/reportModel'); ?>">Download Model Report</a> </li>
                    <li> <a href="<?php echo site_url('Items/reportItem'); ?>">Download Item Report</a> </li>

                 </ul>

            </li>
            <li>
                 <span class="glyphicon glyphicon-list-alt"></span> Download Excel file
                 <ul>
                    <li> <a href="<?php echo site_url('BrandReport'); ?>">Download Brand Report</a> </li>
                    <li> <a href="<?php echo site_url('ModelReport'); ?>">Download Model Report</a> </li>
                    <li> <a href="<?php echo site_url('ItemReport'); ?>">Download Item Report</a> </li>

                 </ul>

            </li>





        </ul>
    </div>

    <!-- Menu's Code Ends here -->
    <div style="text-align:center;background-color:#268ed6;padding-top:2%,padding-bottom:2%;">
        <h1 style="color:white;padding-top:0;padding-bottom:0;"> <img height="60px" width="60px" src="<?php echo base_url('images/item.png') ?>"/> Item Information</h1>
    </div>
    <!-- Main Grid Div -->
    <div>

        <!-- //Successful notification -->
        <div id="SuccessNotification" class="animated slideInUp">
            <div>
                An entry named <span style="color:red;" id="notifsuccess"></span> entered.
            </div>
        </div>

        <!-- //Duplicate notification -->
        <div id="DuplicateNotification" class="animated slideInUp">
            <div>
                An Item named <span style="color:red;" id="notifbn"></span> already exists.
            </div>
        </div>
        <!-- //Required notification -->
        <div id="RequiredNotification" class="animated slideInUp">
            <div>
                <em><span id="notifrequired"></span></em> is required.
            </div>
        </div>

        <div  id='itemGrid'>
            <!-- grid here -->
        </div>
        <div id="btnPanel" style="margin-top:1%;margin-left:1%;margin-right:1%;">
            <a type="button" id="addbtn" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>  Add new Item</a>
            <a id="report"  class="btn btn-info" href="<?php echo site_url('Items/reportItem'); ?>"><span class="glyphicon glyphicon-print"></span> Generate PDF Report</a>
            <a id="reportxls"  class="btn btn-success" ><span class="glyphicon glyphicon-list-alt"></span> Generate EXCEL Report [Only Data]</a>
            <a id="xlreport"  class="btn btn-success" href="<?php echo site_url('ItemReport'); ?>" ><span class="glyphicon glyphicon-list-alt"></span> Generate EXCEL Report [Data Reporting]</a>
        </div>
    </div>

    <!-- Add popup window -->
    <div id="popupWindowadd" class="animated bounceIn">
        <div>Add a new Item </div>
        <div style="overflow: hidden;">
            <table>
                <tr >
                    <td align="left" style="width:50%;">Item Name <span style="color:red">*</span></td>
                    <td align="left" style="width:50%;">
                        <input id="itemNameadd" style="padding-left:3px;width:50%;" required/>

                    </td>



                </tr>

                <tr style="margin-top:10px;">
                    <td align="left" style="margin-top:10px;">Brand </td>
                    <td align="right" style="margin-top:10px;">
                        <!-- //brand dropdown -->
                        <div id="brandDDadd">

                        </div>
                    </td>
                </tr>
                
                <tr style="margin-top:10px;">
                    <td align="left" style="margin-top:10px;">Model </td>
                    <td align="right" style="margin-top:10px;">
                        <!-- models dropdown -->
                        <div id="modelDDadd">

                        </div>
                    </td>
                </tr>

                

                <tr>
                    <td align="right"></td>
                    <td style="padding-top: 10px;" align="right">
                        <input style="margin-right: 5px;background-color:#42eef4" type="button" id="Add" value="Add" />
                        <input id="Canceladd" style="background-color:red" type="button" value="Cancel" />
                    </td>
                </tr>
            </table>
        </div>
    </div>


    <!-- Edit popup window -->
    <div id="popupWindow" class="animated bounceIn">
        <div>Edit Item Information</div>
        <div style="overflow: hidden;">
            <table>
                <tr>
                    <td align="left">Item Name</td>
                    <td align="right"><input id="itemName" style="padding-left:3px;width:50%;" /></td>
                </tr>
                <tr style="margin-top:10px;">
                    <td align="left" style="margin-top:10px;">Brand </td>
                    <td align="right" style="margin-top:10px;">
                        <!-- //brand dropdown -->
                        <div id="brandDD">

                        </div>
                    </td>
                </tr>
                <tr style="margin-top:10px;">
                    <td align="left" style="margin-top:10px;">Model</td>
                    <td align="right" style="margin-top:10px;">
                        <!-- //brand dropdown -->
                        <div id="modelDD">

                        </div>
                    </td>
                </tr>


                <tr>
                    <td align="right"></td>
                    <td style="padding-top: 10px;" align="right">
                        <input style="margin-right: 5px;background-color:#42eef4" type="button" id="Save" value="Save" />
                        <input id="Cancel" style="background-color:red" type="button" value="Cancel" />
                    </td>

                </tr>
            </table>
        </div>
    </div>
    <!-- delete confirmation popup window -->
    <div id="popupWindowdel" class="animated bounceIn">
        <div>Delete Item</div>
        <div style="overflow: hidden;">
            <table>
                <tr style="padding-top: 10px;">
                    Do you want to delete this item named <span style="color:red;" id="bn"></span>?<br>
                    
                </tr>

                <tr align="right">
                    <td align="right"></td>
                    <td style="padding-top: 10px;" align="right">
                        <input style="margin-right: 5px;background-color:red" type="button" id="Delete" value="Delete" />
                        <input id="Canceldel" style="background-color:orange" type="button" value="Cancel" />
                    </td>
                </tr>
            </table>
        </div>
    </div>
    
    <footer style="text-align:center;margin-top:2%;">All rights reserved - Orii &copy; 2017</footer>




    
</body>




</html>











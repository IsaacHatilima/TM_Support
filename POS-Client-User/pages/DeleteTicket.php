<!DOCTYPE html>
<html lang="en">
<head>
	<?php include '../includes/header.php'; ?>
    <script type="text/javascript" src="../../assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="../../assets/js/pages/form_select2.js"></script>
</head>

<body class="navbar-bottom navbar-top">
	<?php include '../includes/topnav.php'; ?>
	<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h6 class="panel-title">Create Ticket</h6>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="tabbable">
                                        <ul class="nav nav-tabs nav-tabs-highlight">
                                            <li class="active"><a href="#general" data-toggle="tab">General Call</a></li>
                                            <!-- <li><a href="#delivery" data-toggle="tab">Delivery Call</a></li> -->
                                        </ul>

                                        <div class="tab-content">
                                            <div class="tab-pane active" id="general">
                                                <div class="panel-body">
                                                    <form class="form-horizontal" id="general_call" action="" method="POST">
                                                        <div class="form-group">
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Ticket Number: </label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="ticket_number" id="ticket_number" class="form-control"  placeholder="Enter Ticket Number" required="required">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row" style="margin-top: 10px">
                                                                    <div class="text-right">
                                                                        <button type="button" id='search' class="btn btn-info">Search <i class="icon-search4 position-left"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Priority: </label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="priority" id="priority" class="form-control"  placeholder="Mechant Name" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Mechant Name: </label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="mech_name" id="mech_name" class="form-control"  placeholder="Mechant Name" readonly>
                                                                    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Mechant ID: </label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="mech_id" id="mech_id" class="form-control"  placeholder="Mechant ID" readonly>
                                                                    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                                                                                    
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Device Serial: </label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="dev_serial" id="dev_serial" class="form-control"  placeholder="Device Serial" readonly>
                                                                    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Category: </label>
                                                                    <div class="col-md-8">

                                                                        <input type="text" name="cate" id="cate" class="form-control"  placeholder="Device Serial" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Sub Category: </label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="sub_cat" id="sub_cat" class="form-control"  placeholder="Device Serial" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Fault Description: </label>
                                                                    <div class="col-md-8">
                                                                        <textarea rows="3" cols="5" name="fault" id="fault"  class="form-control" placeholder="Fault Description" readonly></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Manager's Name: </label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="manager_name" id="manager_name" class="form-control"  placeholder="Enter Manager's Name" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Manager's Cell Number: </label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" name="manager_cell" id="manager_cell" class="form-control"  placeholder="Enter Manager's Cell Number" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Request User: </label>
                                                                    <div class="col-md-8">
                                                                    <input type="text" name="requester" id="requester" class="form-control"  placeholder="Enter Manager's Name" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>                                           
                                                        </div>
                                                        <div class="text-right">
                                                            <button type="button" id='delete_ticket' class="btn btn-danger">Delete <i class="icon-trash position-left"></i></button>
                                                        </div>
                                                    </form>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>						
                    </div>
                    <div class="col-md-2"></div>
                </div>
			</div>
		</div>
	</div>
    <div id="lock-modal"></div>
    <div id="loading-circle"></div>
	<script src="../ajax/DeleteTicket.js"></script>
</body>
</html>

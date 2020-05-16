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
                            <?php
                                $ticket_id = $_GET['pos_ticket_id'];
                                list($ticket_id, $enc_iv) = explode("::", $ticket_id);  
                                $cipher_method = 'aes-128-ctr';
                                $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
                                $token = openssl_decrypt($ticket_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
                                $ticket_id = $token;
                            ?>
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Ticket No <?php echo sprintf("%04d", $ticket_id); ?></b></h3>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" id="general_call" action="" method="POST">
                                    <div class="form-group">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">Call Status: </label>
                                                <div class="col-md-8">
                                                    <input type="text" style="font-weight: bold;" name="status" id="status" class="form-control"  placeholder="Mechant Name" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">Priority: </label>
                                                <div class="col-md-8">
                                                    <input type="text" name="priority" id="priority" class="form-control"  placeholder="Mechant Name" readonly>
                                                    <input type="hidden" name="ticket_number" id="ticket_number"  value="<?php echo  $ticket_id;?>" readonly>
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
                                        <div class="col-md-8" id="engineers" style="display:block">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">Engineer: </label>
                                                <div class="col-md-8">
                                                <input type="text" name="engin1" id="engin1" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>    
                                        <div class="col-md-8" id="solu">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">Solution: </label>
                                                <div class="col-md-8">
                                                    <textarea rows="3" cols="5" name="solution" id="solution"  class="form-control" placeholder="Solution" readonly></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">Time Logged: </label>
                                                <div class="col-md-8">
                                                <input type="text" name="logtime" id="logtime" class="form-control"  readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">Time Closed: </label>
                                                <div class="col-md-8">
                                                <input type="text" name="closetime" id="closetime" class="form-control"  readonly>
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="col-md-8">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">Resolution Time: </label>
                                                <div class="col-md-8">
                                                <input type="text" name="resolvetime" id="resolvetime" class="form-control"  readonly>
                                                </div>
                                            </div>
                                        </div>                                                                            
                                    </div>
                                </form>
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
	<script src="../ajax/AcceptCall.js"></script>
    <script>
        $(document).ready(function(){
            event.preventDefault();
            $("#lock-modal").css("display", "block");
            $("#loading-circle").css("display", "block");
            var ex = document.getElementById("ticket_number").value;
            $.ajax({
                type: "post",
                url: "../core/AcceptCallCore.php",
                data: {"tikid" : ex},
                success: function(strMessage) {
                    console.log(strMessage);
                    var xx = strMessage;
                    if (xx != 'Nothing' || xx != 'Error') {
                        var obj = JSON.parse(strMessage); 
                        $('#status').val(obj.status);
                        $('#priority').val(obj.priority);
                        $('#cate').val(obj.cate);
                        $('#sub_cat').val(obj.sub_category);
                        $('#dev_serial').val(obj.call_device_serial);
                        $('#fault').val(obj.fault_details);
                        $('#manager_name').val(obj.managers_name);
                        $('#manager_cell').val(obj.managers_cell); 
                        $('#requester').val(obj.names); 
                        $('#mech_name').val(obj.mech_name); 
                        $('#mech_id').val(obj.mech_id); 
                        $('#engin1').val(obj.eng_names); 
                        $('#solution').val(obj.solution); 
                        $('#logtime').val(obj.logtime); 
                        $('#closetime').val(obj.closetime); 
                        $('#resolvetime').val(obj.repair_time); 
                        
                        var state = document.getElementById("status").value;
                        if(state === 'New')
                        {
                            document.getElementById("status").style.color = 'steelblue';
                        }
                        if(state === 'Open')
                        {
                            document.getElementById("status").style.color = 'orangered';
                        }
                        if(state === 'Closed')
                        {
                            document.getElementById("status").style.color = 'green';
                        }
                        $("#lock-modal").css("display", "none");
                        $("#loading-circle").css("display", "none");
                    }
                    if (xx == 'Nothing') {    
                        iziToast.show({
                            title: 'Warning!',
                            message: 'This Ticket Does No Exist.',
                            color: 'yello',
                            position: 'topRight',
                            icon: 'fa fa-check',
                            timeout: 2000
                        });    
                        $("#lock-modal").css("display", "none");
                        $("#loading-circle").css("display", "none");
                    }
                    if (xx == 'Error') {    
                        iziToast.show({
                            title: 'Error!',
                            message: 'An Error Occured. Please Try Again.',
                            color: 'red',
                            position: 'topRight',
                            icon: 'fa fa-check',
                            timeout: 2000
                        });    
                        $("#lock-modal").css("display", "none");
                        $("#loading-circle").css("display", "none");
                    }
                }
            });
        });

    </script>
</body>
</html>

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
            <div id="lock-modal"></div>
            <div id="loading-circle"></div>
			<div class="content-wrapper">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="panel panel-flat">
                            <?php
                                $ticket_id = $_GET['atm_ticket_id'];
                                list($ticket_id, $enc_iv) = explode("::", $ticket_id);  
                                $cipher_method = 'aes-128-ctr';
                                $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
                                $token = openssl_decrypt($ticket_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
                                $ticket_id = $token;
                            ?>
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3 class="panel-title"><b>Ticket No <?php echo sprintf("%04d", $ticket_id); ?></b></h3>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" id="prints" class="btn btn-primary pull-right" style="display:none"> <i class="icon-printer position-left"></i> Print Job Card</button>
                                    </div>
                                </div>
                                
                                
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" id="general_call" action="" method="POST">
                                    <div class="form-group">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">Call Status: </label>
                                                <div class="col-md-8">
                                                    <input type="text" style="font-weight: bold;" name="status" id="status" class="form-control"  placeholder="Call Status" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">ATM Site: </label>
                                                <div class="col-md-8">
                                                    <input type="text" name="atm_site" id="atm_site" class="form-control"  placeholder="ATM Site" readonly>
                                                
                                                </div>
                                            </div>
                                        </div>                                                
                                        <div class="col-md-8">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">ATM Name: </label>
                                                <div class="col-md-8">
                                                    <input type="text" name="atm_name" id="atm_name" class="form-control"  placeholder="ATM Name" readonly>
                                                
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
                                                <label class="col-md-4 control-label text-right">Looged User: </label>
                                                <div class="col-md-8">
                                                <input type="text" name="requester" id="requester" class="form-control"  placeholder="Enter Manager's Name" readonly>
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
                                        <div class="col-md-8" id="engineers">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">Engineer: </label>
                                                <div class="col-md-8">
                                                <input type="text" name="engin1" id="engin1" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>   
                                        <div class="col-md-8" id="solu" style="display:none">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">Solution: </label>
                                                <div class="col-md-8">
                                                    <textarea rows="3" cols="5" name="solution" id="solution"  class="form-control" placeholder="Solution" readonly></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8" id="clo_time" style="display:none">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">Time Closed: </label>
                                                <div class="col-md-8">
                                                <input type="text" name="closetime" id="closetime" class="form-control"  readonly>
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="col-md-8" id="sol_time" style="display:none">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">Resolution Time: </label>
                                                <div class="col-md-8">
                                                <input type="text" name="resolvetime" id="resolvetime" class="form-control"  readonly>
                                                <input type="hidden" value="<?php echo $_GET['atm_ticket_id'] ?>" name="ticket_number" id="ticket_number" class="form-control"  readonly>
                                                </div>
                                            </div>
                                        </div>                                                                            
                                    </div>
                                    <div class="text-right">
                                    </div>

                                    <!-- Custodian modal -->
                                    <div id="modal_default" class="modal fade" style="margin-top:150px">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h5 class="modal-title">Custodian Status Update</h5>
                                                </div>

                                                <div class="modal-body">
                                                    <textarea rows="5" cols="5" id="custodianz" class="form-control" placeholder="Enter Custodian Status"></textarea>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                                    <button type="button" id="cust_state_btn" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Custodian modal -->
                                    <!-- Delay modal -->
                                    <div id="modal_default2" class="modal fade" style="margin-top:150px">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h5 class="modal-title">Reson For Delay</h5>
                                                </div>

                                                <div class="modal-body">
                                                    <textarea rows="5" cols="5" id="delay_reson" class="form-control" placeholder="Enter Reson For Delay"></textarea>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                                    <button type="button" id="reasonDelayed" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Delay modal -->

                                </form>
                            </div>
                        </div>						
                    </div>
                    <div class="col-md-2"></div>
                </div>
			</div>
		</div>
	</div>
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
                        $('#atm_site').val(obj.atmSite); 
                        $('#atm_name').val(obj.atmName);
                        $('#cate').val(obj.cate);
                        $('#sub_cat').val(obj.sub_category);
                        $('#fault').val(obj.fault_details);
                        $('#requester').val(obj.names); 
                        $('#engin1').val(obj.eng_names);
                        $('#solution').val(obj.solution); 
                        $('#logtime').val(obj.logtime); 
                        $('#closetime').val(obj.closetime); 
                        $('#resolvetime').val(obj.repair_time); 
                        // $('#custodianz').val(obj.custodian_sta); 
                        // $('#delay_reson').val(obj.reson_for_delay); 

                        // var Cusstate = document.getElementById("custodianz").value;
                        // if(Cusstate !== '')
                        // {
                        //     $("#cust_state_btn").css("display", "none");
                        //     document.getElementById('custodianz').readOnly = true;
                        // }
                        // var RDelay = document.getElementById("delay_reson").value;
                        // if(RDelay !== '')
                        // {
                        //     $("#reasonDelayed").css("display", "none");
                        //     document.getElementById('delay_reson').readOnly = true;
                        // }
                        
                        var state = document.getElementById("status").value;
                        if(state === 'New')
                        {
                            document.getElementById("status").style.color = 'steelblue';
                            $("#engineers").css("display", "none"); 
                        }
                        if(state === 'Open')
                        {
                            document.getElementById("status").style.color = 'orangered';
                            $("#solu").css("display", "none");
                            $("#engineers").css("display", "block"); 
                        }
                        if(state === 'Closed')
                        {
                            document.getElementById("status").style.color = 'green';
                            $("#solu").css("display", "block");
                            $("#clo_time").css("display", "block");
                            $("#sol_time").css("display", "block");
                            $("#prints").css("display", "block");
                            $("#engineers").css("display", "block"); 
                            document.getElementById("solution").readOnly  = true;
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

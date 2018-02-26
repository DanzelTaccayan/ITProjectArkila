@extends('layouts.form_lg') 
@section('links')
@parent
<style>
        /* Mark input boxes that gets an error on validation: */

        /* Hide all steps by default: */

        .tab {
            display: none;
        }



        /* Make circles that indicate the steps of the form: */

        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */

        .step.finish {
            background-color: #4CAF50;
        }
    </style>
@endsection
@section('title', 'Operator Registration')
@section('form-id','regForm')
@section('form-action','#')
@section('form-body')
<div class="box box-primary">
        <div class="box-header with-border text-center">
            <a href="" class="pull-left btn btn-default"><i class="fa  fa-chevron-left"></i></a>
            <h3 class="box-title">
                Operator Registration
            </h3>
        </div>
        <div class="box-body">

                <!-- One "tab" for each step in the form: -->
                <div class="tab">
                    <h4>Personal Information</h4>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Last Name:</label>
                                <input type="text" class="form-control" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>First Name:</label>
                                <input type="text" class="form-control" placeholder="First Name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Middle Name:</label>
                                <input type="text" class="form-control" placeholder="Middle Name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                             <div class="form-group">
                                <label>Contact Number:</label>
                                <input type="text" class="form-control" placeholder="Contact Number">
                            </div>
                        </div>
                        <div class="col-md-4">
                             <div class="form-group">
                                <label>Address:</label>
                                <input type="text" class="form-control" placeholder="Address">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Provincial Address:</label>
                                <input type="text" class="form-control" placeholder="Provincial Address">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Age:</label>
                                <input type="number" class="form-control" placeholder="Age">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Birthdate:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Birthplace:</label>
                                <input type="text" class="form-control" placeholder="Birthplace">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Gender:</label>
                                <div class="radio">
                                    <label for=""> Male</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender"  value="male" class="flat-blue">
                                    </label>
                                    <label for="">Female</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="female" class="flat-blue">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Citizenship:</label>
                                <input type="text" class="form-control" placeholder="Citizenship">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Civil Status:</label>
                                <select class="form-control">
                                   <option>Single</option>
                                   <option>Married</option>
                                   <option>Divorced</option>
                                   <option>Widowed</option>
                               </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>SSS No:</label>
                                <input type="text" class="form-control" placeholder="SSS No.">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>License No:</label>
                                <input type="text" class="form-control" placeholder="License No.">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>License Expiry Date:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right datepicker">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab">
                    <h4>Family Information</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name of Spouse:</label>
                                <input type="text" class="form-control" placeholder="Name of Spouse">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Birthdate of Spouse:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right datepicker">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fathers Name:</label>
                                <input type="text" class="form-control" placeholder="Fathers Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Occupation:</label>
                                <input type="text" class="form-control" placeholder="Occupation">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                             <div class="form-group">
                                <label>Mothers Name:</label>
                                <input type="number" class="form-control" placeholder="Mothers Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Occupation:</label>
                                <input type="text" class="form-control" placeholder="Occupation">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Contact Person</label>
                                <input type="text" class="form-control" placeholder="Contact Person In Case of Emergency">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" placeholder="Address">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Contact Number</label>
                                <input type="text" class="form-control" placeholder="Contact Number">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <Label>Dependents:</Label>
                            <table class="table table-hover custab">
                                <thead>
                                    <th>Name</th>
                                    <th>Birthdate</th>
                                    <th>
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-info" onclick="addItem()"><i class="fa fa-plus-circle"></i> Add Item</button>
                                        </div>
                                    </th>
                                </thead>
                                <tbody id="childrens">
                                    <tr>
                                        <td>
                                            <input type="text" placeholder="Name of Child" class="form-control">
                                        </td>
                                        <td>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right datepicker">
                                            </div>
                                        </td>
                                        <td>
                                        <div class="pull-right">
                                        <button style="display: none;" type="button" onclick="event.srcElement.parentElement.parentElement.parentElement.remove();rmv()" class='btn btn-danger'>Delete</button>
                                    </div>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                
                <!-- Circles which indicates the steps of the form: -->
                <div style="text-align:center;margin-top:40px;">
                    <span class="step"></span>
                    <span class="step"></span>
                </div>
        </div>
        <div class="box-footer">
            <div style="overflow:auto;">
                    <div style="float:right;">
                        <button type="button" id="prevBtn" onclick="nextPrev(-1)" class = "btn btn-default">Previous</button>
                        <button type="button" id="nextBtn" onclick="nextPrev(1)" class = "btn btn-primary">Next</button>
                    </div>
                </div>
        </div>
    </div>
@endsection
@section('scripts')
@parent
 <script>    

        $(cloneDatePicker());

        function cloneDatePicker() {

            //Date picker
            $('.datepicker').datepicker({
                autoclose: true
            })

        }



        function addItem() {
            var tablebody = document.getElementById('childrens');
            if (tablebody.rows.length == 1) {
                tablebody.rows[0].cells[tablebody.rows[0].cells.length - 1].children[0].children[0].style.display = "";
            }   


            var tablebody = document.getElementById('childrens');
            var iClone = tablebody.children[0].cloneNode(true);
            for (var i = 0; i < iClone.cells.length; i++) {
                iClone.cells[i].children[0].value = "";
                iClone.cells[1].children[0].children[1].value="";
            
            }
            tablebody.appendChild(iClone);
            cloneDatePicker();
        }
        

        function rmv() {
            var tabRow = document.getElementById("childrens");
            if (tabRow.rows.length == 1) {
                tabRow.rows[0].cells[tabRow.rows[0].cells.length - 1].children[0].children[0].style.display = "none";
            } else {
                tabRow.rows[0].cells[tabRow.rows[0].cells.length - 1].children[0].children[0].style.display = "";
            }
        }
    </script>

    <script>
     var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the crurrent tab

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                document.getElementById("regForm").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields


            return true; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace("active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
    </script>
    <script>
    $(function () {

        $('.select2').select2()

        $('#datepicker').datepicker({
          autoclose: true
        })

        $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass   : 'iradio_flat-blue'
        })
    })
    </script>

    
@endsection
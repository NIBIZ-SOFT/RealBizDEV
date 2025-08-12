<?php
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$MainContent .= '
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

    <div class="card text-center" style="width: 100%; margin: auto;">
        <div class="card-head text-center m-3" style="background-color: #295F98;">
            <h4 style="color: white; margin-top:15px;">Manage BOQ</h4>
            <h4><a href="./index.php?Theme=default&Base=BOQ&Script=Insertupdate" class="btn btn-primary">Create New BOQ</a></h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover data-table">
                    <thead style="background-color: #295F98;">
                        <tr class="text-center fw-bold">
                            <th style="color: white;">Project Name</th>
                            <th style="color: white;">BOQ Title</th>
                            <th style="color: white;">Date</th>
                            <th style="color: white;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="projectTableBody" class="text-center">
                        <!-- AJAX-loaded rows will appear here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "./index.php?Theme=default&Base=BOQ&Script=loadBOQ&NoHeader&NoFooter",
            dataType: "json",
            success: function(response) {
                if (response.success === true && response.loadedHTML) {
                    $("#projectTableBody").html(response.loadedHTML);
                } else {
                    $("#projectTableBody").html("<tr><td colspan=\'4\'>No records found.</td></tr>");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", status, error);
                $("#projectTableBody").html("<tr><td colspan=\'4\'>Error loading data.</td></tr>");
            }
        });
    });
    </script>
';

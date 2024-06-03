<?php
require_once("../db_connect.php");

$sqlAll="SELECT * FROM campground_info";
$resultAll = $conn->query($sqlAll);
$allCampgroundCount = $resultAll->num_rows;

if(isset($_GET["search"])){
    $search=$_GET["search"];
    $sql="SELECT id, campground_name , phone, email, position FROM campground_info WHERE campground_name LIKE '%$search%'";
    $pageTitle="$search 的搜尋結果";
}else if(isset($_GET["page"]) && isset($_GET["order"])){
    $page=$_GET["page"];
    $perPage=5;
    $firstItem=($page-1)*$perPage;
    $pageCount = ceil($allCampgroundCount/$perPage);

    $order=$_GET["order"];
    switch($order){
        case 1:// id ASC
            $orderClause= "ORDER BY id ASC";
            break;
        case 2:// id DESC
            $orderClause= "ORDER BY id DESC";
            break;
        case 3:// 名字 ASC
            $orderClause= "ORDER BY campground_name ASC";
            break;
         case 4:// 名字 DESC
            $orderClause= "ORDER BY campground_name DESC";
            break;
    }
    $sql="SELECT * FROM campground_info $orderClause  LIMIT $firstItem, $perPage";

    $pageTitle="營地列表，第 $page 頁";
}else{
    $sql="SELECT id, campground_name , phone, email, position FROM campground_info";
    $pageTitle="營地列表";
    // header("location: campground_list2.php?page=1&order=1");
}

$result = $conn->query($sql);
$rows=$result->fetch_all(MYSQLI_ASSOC);
$campCount = $result->num_rows;

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="icon" type="image/png" href="assets/img/favicon.ico">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

  <title>Fresh Bootstrap Table by Creative Tim</title>

  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="assets/css/fresh-bootstrap-table.css" rel="stylesheet" />
  <link href="assets/css/demo.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link href="http://fonts.googleapis.com/css?family=Roboto:400,700,300" rel="stylesheet" type="text/css">

  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://unpkg.com/bootstrap-table/dist/bootstrap-table.min.js"></script>

  <!--  Just for demo purpose, do not include in your project   -->
  <!-- <script src="assets/js/demo/gsdk-switch.js"></script>
  <script src="assets/js/demo/jquery.sharrre.js"></script>
  <script src="assets/js/demo/demo.js"></script> -->

</head>
<body>


  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="description">
          <h2>Fresh Bootstrap Table</h2>
        </div>

        <div class="fresh-table full-color-azure">
        <!--
          Available colors for the full background: full-color-blue, full-color-azure, full-color-green, full-color-red, full-color-orange
          Available colors only for the toolbar: toolbar-color-blue, toolbar-color-azure, toolbar-color-green, toolbar-color-red, toolbar-color-orange
        -->
          <div class="toolbar">
            <button id="alertBtn" class="btn btn-default">Alert</button>
          </div>

          <table id="fresh-table" class="table">
            <thead>
              <th data-field="id">ID</th>
              <th data-field="name" data-sortable="true">Name</th>
              <th data-field="salary" data-sortable="true">Salary</th>
              <th data-field="country" data-sortable="true">Country</th>
              <th data-field="city">City</th>
              <th data-field="actions" data-formatter="operateFormatter" data-events="operateEvents">Actions</th>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Dakota Rice</td>
                <td>$36,738</td>
                <td>Niger</td>
                <td>Oud-Turnhout</td>
                <td></td>
              </tr>

            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>





</body>
  <script type="text/javascript">
    var $table = $('#fresh-table')
    var $alertBtn = $('#alertBtn')

    window.operateEvents = {
      'click .like': function (e, value, row, index) {
        alert('You click like icon, row: ' + JSON.stringify(row))
        console.log(value, row, index)
      },
      'click .edit': function (e, value, row, index) {
        alert('You click edit icon, row: ' + JSON.stringify(row))
        console.log(value, row, index)
      },
      'click .remove': function (e, value, row, index) {
        $table.bootstrapTable('remove', {
          field: 'id',
          values: [row.id]
        })
      }
    }

    function operateFormatter(value, row, index) {
      return [
        '<a rel="tooltip" title="Like" class="table-action like" href="javascript:void(0)" title="Like">',
          '<i class="fa fa-heart"></i>',
        '</a>',
        '<a rel="tooltip" title="Edit" class="table-action edit" href="javascript:void(0)" title="Edit">',
          '<i class="fa fa-edit"></i>',
        '</a>',
        '<a rel="tooltip" title="Remove" class="table-action remove" href="javascript:void(0)" title="Remove">',
          '<i class="fa fa-remove"></i>',
        '</a>'
      ].join('')
    }

    $(function () {
      $table.bootstrapTable({
        classes: 'table table-hover table-striped',
        toolbar: '.toolbar',

        search: true,
        showRefresh: true,
        showToggle: true,
        showColumns: true,
        pagination: true,
        striped: true,
        sortable: true,
        pageSize: 5,
        pageList: [5, 10],

        formatShowingRows: function (pageFrom, pageTo, totalRows) {
          return ''
        },
        formatRecordsPerPage: function (pageNumber) {
          return pageNumber + ' rows visible'
        }
      })

      $alertBtn.click(function () {
        alert('You pressed on Alert')
      })
    })

    
  </script>

  <!-- <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga')

    ga('create', 'UA-46172202-1', 'auto')
    ga('send', 'pageview')

  </script> -->

</html>

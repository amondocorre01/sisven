<?php 
ob_start();
session_start();
include ("../_init.php");

// Redirect, If user is not logged in
if (!is_loggedin()) {
  redirect(root_url() . '/index.php?redirect_to=' . url());
}

// Redirect, If User has not Read Permission
if (user_group_id() != 1 && !has_permission('access', 'read_supplier')) {
  redirect(root_url() . '/'.ADMINDIRNAME.'/dashboard.php');
}

// Set Document Title
$document->setTitle(trans('text_supplier_list_title'));

// Add Script
//$document->addScript('../assets/itsolution24/angular/controllers/AsignPricesController.js');
//$document->addScript('../assets/itsolution24/angular/controllers/SupplierController.js');


// Include Header and Footer
include("header.php"); 
include ("left_sidebar.php"); 
?>
<!--Tree-->
<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"/>-->
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet"/>
<!---->

<!--rr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" integrity="sha512-A81ejcgve91dAWmCGseS60zjrAdohm7PTcAjjiDWtw3Tcj91PNMa1gJ/ImrhG+DbT5V+JQ5r26KT5+kgdVTb5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.js" integrity="sha512-Hyk+1XSRfagqzuSHE8M856g295mX1i5rfSV5yRugcYFlvQiE3BKgg5oFRfX45s7I8qzMYFa8gbFy9xMFbX7Lqw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<link href="../assets/estilos/estilos.css" type="text/css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Content Wrapper Start -->
<div class="content-wrapper" >

  <!-- Content Header Start -->
  <section class="content-header">
    <h1>
      CONTABILIDAD
      <small>
        <?php echo store('name'); ?>
      </small>
    </h1>
    <ol class="breadcrumb">
      <li>
        <a href="dashboard.php">
          <i class="fa fa-dashboard"></i> 
          <?php echo trans('text_dashboard'); ?>
        </a>
      </li>
      <li class="active">
        CONTABILIDAD
      </li>
    </ol>
  </section>
  <!-- Content Header End -->

  <!-- Content Start -->
  <section class="content">

    <?php if(DEMO) : ?>
    <div class="box">
      <div class="box-body">
        <div class="alert alert-info mb-0">
          <p><span class="fa fa-fw fa-info-circle"></span> <?php echo $demo_text; ?></p>
        </div>
      </div>
    </div>
    <?php endif; ?>
    
    <?php if (user_group_id() == 1 || has_permission('access', 'create_supplier')) : ?>
    <div class="box box-info<?php echo create_box_state(); ?>">
      <?php if (isset($error_message)): ?>
        <div class="alert alert-danger">
            <p>
              <span class="fa fa-warning"></span> 
              <?php echo $error_message ; ?>
            </p>
        </div>
      <?php elseif (isset($success_message)): ?>
        <div class="alert alert-success">
            <p>
              <span class="fa fa-check"></span> 
              <?php echo $success_message ; ?>
            </p>
        </div>
      <?php endif; ?>

      <!-- Add Supplier Create Form -->
      <?php include('../_inc/template/supplier_create_form.php'); ?>

    </div>
    <?php endif; ?>

    
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">

              <div class="row">
                <div class="col-offset-1 col-md-2">
                </div>
                
                <div class="btn-save-prices box-body">
                  
                </div> 
              </div>
              
            
          </div>
          
          <div class="box-body">
            <div class="container">
                <!--<div id="tree"></div>-->

                <div class="row">
                    <hr>
                    <h2>Searchable Tree</h2>
                    <div class="col-sm-4">
                    <h2>Input</h2>
                    <!-- <form> -->
                        <div class="form-group">
                        <label for="input-search" class="sr-only">Search Tree:</label>
                        <input type="input" class="form-control" id="input-search" placeholder="Type to search..." value="">
                        </div>
                        <div class="checkbox">
                        <label>
                            <input type="checkbox" class="checkbox" id="chk-ignore-case" value="true" checked>
                            Ignore Case
                        </label>
                        </div>
                        <div class="checkbox">
                        <label>
                            <input type="checkbox" class="checkbox" id="chk-exact-match" value="false">
                            Exact Match
                        </label>
                        </div>
                        <div class="checkbox">
                        <label>
                            <input type="checkbox" class="checkbox" id="chk-reveal-results" value="true" checked>
                            Reveal Results
                        </label>
                        </div>
                        <button type="button" class="btn btn-success" id="btn-search">Search</button>
                        <button type="button" class="btn btn-default" id="btn-clear-search">Clear</button>
                    <!-- </form> -->
                    </div>
                    <div class="col-sm-4">
                    <h2>Tree</h2>
                    <div id="treeview-searchable" class="treeview"></div>
                    
                    </div>
                    <div class="col-sm-4">
                    <h2>Results</h2>
                    <div id="search-output"></div>
                    </div>
                </div>

                    <div id="tree"></div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Content End -->
</div>
<!-- Content Wrapper End -->

<?php include ("footer.php"); ?>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js"></script>

<script>
    /* OPCION 1
    $(document).ready(function(){
        $('#tree span[data-id]').on('click',function(e){
            let padre = $(this).parent();
            let iden = $(this).data("id");
            console.log('iden',iden);
            $(".btn-tree").remove();
            let boton = `<button onclick="btnPlussTree(this)" iden="${iden}" 
            class="btn btn-primary btn-xs btn-tree" ><i class="fa fa-plus"></i></button>`;
            $(padre).append(boton);
        });
    });

    function btnPlussTree(e){
            let id = $(e).attr('iden');
            console.log('agregará items en ',id);
    }

$('#tree').tree({
  dataSource: [ 
    { 
      text: '<span data-id="1">ACTIVO</span>', 
      children: [ 
        { text: '<span data-id="2">ACTIVO 1</span>', 
         children: [
           { text: '<span data-id="3">ACTIVO 1.1</span>',
             children: [
               { text: '<span data-id="4">ACTIVO 1.1.1</span>' },
               { text: '<span data-id="5">ACTIVO 1.1.2</span>' },
               { text: '<span data-id="6">ACTIVO 1.1.3</span>' }
             ]
           }
         ] 
        } 
      ] 
    },{
        text: '<span data-id="7">PASIVO</span>',
        children:[
            {text: '<span data-id="8">PASIVO 1</span>'}
        ]
    },{
        text: '<span data-id="9">PATRIMONIO</span>',
        children:[
            {text: '<span data-id="10">PATRIMONIO 1</span>'}
        ]
    }
  ]
});*/
//https://github.com/jonmiles/bootstrap-treeview

//https://raw.githubusercontent.com/jonmiles/bootstrap-treeview/master/public/js/bootstrap-treeview.js
//https://rawgit.com/jonmiles/bootstrap-treeview/master/public/js/bootstrap-treeview.js

//https://raw.githubusercontent.com/jonmiles/bootstrap-treeview/master/public/css/bootstrap-treeview.css
//https://rawgit.com/jonmiles/bootstrap-treeview/master/public/css/bootstrap-treeview.css

// Dependencies
//Bootstrap v3.3.4 (>= 3.0.0)
//jQuery v2.1.3 (>= 1.9.0)
$(document).ready(function(){
    var tree1 = [ { 
      text: `<span onclick="btnSpanTree(this)" data-id="1">ACTIVO</span> 
      <button onclick="btnPlussTree(this)" iden="1" class="btn btn-danger btn-xs btn-tree" ><i class="fa fa-minus"></i></button>
      <button onclick="btnPlussTree(this)" iden="1" class="btn btn-primary btn-xs btn-tree" ><i class="fa fa-plus"></i></button>
      <button onclick="btnPlussTree(this)" iden="1" class="btn btn-info btn-xs btn-tree" ><i class="fa fa-eye"></i></button>`, 
      nodes: [ 
        { text: '<span onclick="btnSpanTree(this)" data-id="2">ACTIVO 1</span>', 
         nodes: [
           { text: '<span onclick="btnSpanTree(this)" data-id="3">ACTIVO 1.1</span>',
            nodes: [
               { text: '<span onclick="btnSpanTree(this)" data-id="4">ACTIVO 1.1.1</span>' },
               { text: '<span onclick="btnSpanTree(this)" data-id="5">ACTIVO 1.1.2</span>' },
               { text: '<span onclick="btnSpanTree(this)" data-id="6">ACTIVO 1.1.3</span>' }
             ]
           }
         ] 
        } 
      ] 
    },{
        text: '<span onclick="btnSpanTree(this)" data-id="7">PASIVO</span>',
        nodes:[
            {text: '<span onclick="btnSpanTree(this)" data-id="8">PASIVO 1</span>'}
        ]
    },{
        text: '<span onclick="btnSpanTree(this)" data-id="9">PATRIMONIO</span>',
        nodes:[
            {text: '<span onclick="btnSpanTree(this)" data-id="10">PATRIMONIO 1</span>'}
        ]
    }
  ];

function getTree() {
  // Some logic to retrieve, or generate tree structure
  return tree1;
}


var $searchableTree = $('#treeview-searchable').treeview({
   data: getTree(),
});

var search = function(e) {
  var pattern = $('#input-search').val();
  var options = {
    ignoreCase: $('#chk-ignore-case').is(':checked'),
    exactMatch: $('#chk-exact-match').is(':checked'),
    revealResults: $('#chk-reveal-results').is(':checked')
  };
  var results = $searchableTree.treeview('search', [ pattern, options ]);

  var output = '<p>' + results.length + ' matches found</p>';
  $.each(results, function (index, result) {
    output += '<p>- ' + result.text + '</p>';
  });
  $('#search-output').html(output);
}

$('#btn-search').on('click', search);
$('#input-search').on('keyup', search);

$('#btn-clear-search').on('click', function (e) {
  $searchableTree.treeview('clearSearch');
  $('#input-search').val('');
  $('#search-output').html('');
});
    /*
    $('#treeview-searchable ul li span[data-id]').on('click',function(e){
        let padre = $(this).parent();
        let iden = $(this).data("id");
        console.log('iden',iden);
        $(".btn-tree").remove();
        let boton = `<button onclick="btnPlussTree(this)" iden="${iden}" 
        class="btn btn-primary btn-xs btn-tree" ><i class="fa fa-plus"></i></button>`;
        $(padre).append(boton);
    });*/

    

});

    function btnSpanTree(e){
        let padre = $(e).parent();
        let iden = $(e).data("id");
        console.log('iden',iden);
        //$(".btn-tree").remove();
        let boton = `<button onclick="btnPlussTree(this)" iden="${iden}" 
        class="btn btn-primary btn-xs btn-tree" ><i class="fa fa-plus"></i></button>`;
        $(padre).append(boton);
    }

    function btnPlussTree(e){
        let id = $(e).attr('iden');
        console.log('agregará items en ',id);
    }

</script>

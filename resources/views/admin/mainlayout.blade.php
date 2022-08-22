<!DOCTYPE html>
<html lang="en">
  @include('admin.parts.head')
  <style type="text/css">
    .modal-load {
        display:    none;
        position:   fixed;
        z-index:    10000;
        top:        0;
        left:       0;
        height:     100%;
        width:      100%;
        background: rgba( 255, 255, 255, .8 ) 
                    url('https://i.imgur.com/1nz9QC4.gif') 
                    50% 50% 
                    no-repeat;
    }

    /* When the body has the loading class, we turn
       the scrollbar off with overflow:hidden */
    body.loading .modal-load {
        overflow: hidden;   
    }

    /* Anytime the body has the loading class, our
       modal element will be visible */
    body.loading .modal-load {
        display: block;
    }

    .vcenter {
        display: inline-block;
        vertical-align: middle;
        float: none;
    }

    .vertical-align {
        display: flex;
        align-items: center;
    }

    /* .select2 {
      width:100%!important;
    } */

  </style>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__wobble" src="{{ asset('assets') }}/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

    @include('admin.parts.header')

    @include('admin.parts.sidebar')
    
    @yield('content')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2022 <a href="#">Sistem Akuntansi</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
      </div>
    </footer>

</div>

<div class="modal-load"><!-- Place at bottom of page --></div>

@include('admin.parts.script-footer')

  <script type="text/javascript">

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }

    function updateTextView(_obj){
      var num = getNumber(_obj.val());
      if(num==0){
        _obj.val('');
      }else{
        _obj.val(numberWithCommas(num));
      }
    }
    function getNumber(_str){
      var arr = _str.split('');
      var out = new Array();
      for(var cnt=0;cnt<arr.length;cnt++){
        if(isNaN(arr[cnt])==false){
          out.push(arr[cnt]);
        }
      }
      return Number(out.join(''));
    }

    function formatDate(dateStr) {

        let str = '';

        if(dateStr != null){
          let split = dateStr.split("-");
          str = split[2] + '/' + split[1] + '/' + split[0];
        }

        return str;

        // const d = new Date(dateStr);
         // + ' ' + d.getHours() + ':' + d.getMinutes().toString().padStart(2, '0')
        // return d.getDate().toString().padStart(2, '0') + '/' + d.getMonth() + 1 + '/' + d.getFullYear();
    }

    $(function(){

      $('.currency').on('keyup',function(){
        updateTextView($(this));
      });
      
      $('.select2').select2({
        theme: 'bootstrap4'
      })

    });
  </script>

  @yield('scriptplus')  

</body>
</html>
{!! Html::script('assets/js/jquery-2.1.4.min.js')!!}
{!! Html::script('assets/plugins/jquery-ui-1.11.4/jquery-ui.min.js')!!}
{!! Html::script('assets/materialize_0.97.4/js/materialize.min.js')!!}
<!-- @yield('reactjs') -->
{!! Html::script('assets/js/init.js')!!}
{!! Html::script('assets/plugins/sidr/js/jquery.sidr.min.js')!!}
{!! Html::script('assets/plugins/touchwipe/js/jquery.touchwipe.min.js')!!}
{!! Html::script('assets/js/hack.js')!!}
<?php if(Sentinel::check()){?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.5/socket.io.min.js"></script>
  <script>
    var socket = io.connect("<?=config('database.lite_node_server')?>",{query:"data=<?=UserService::getUserIdHash()?>" });
  </script>
<?php } ?>
{!! Html::script('assets/plugins/vanilla-masker/vanilla-masker.min.js')!!}
{!! Html::script('assets/js/lite-script.js')!!}
@yield('customjs')
<script src="https://use.fonticons.com/2c2b6e96.js"></script>
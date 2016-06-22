<li id="{{$data['type']."_".$data['id']}}" data-value="{{$data['id']}}" data-type="{{$data['type']}}">
  <span><name>{{$data['name']}}</name>
    <a href="#!" class="ml5 editName" data-name="{{$data['name']}}" data-type="{{$data['type']}}" data-id="{{$data['id']}}" data-url="{{route('setting.' . $data['type'] . '.update-text')}}" data-tooltip="Edit this Node">
      <i class="fa fa-pencil-square-o red1-text"></i>
    </a>
    <a href="#!" data-url="{{route('setting.' . $data['type'] . '.delete')}}" data-id="{{$data['id']}}" data-tooltip="Delete this Node" class="deleteJobDepartement">
      <i class="fa fa-trash red1-text"></i>
    </a>
  </span>
  <ul>
     @each('partials.tree', $data['children'],'data')
  </ul>
</li>
